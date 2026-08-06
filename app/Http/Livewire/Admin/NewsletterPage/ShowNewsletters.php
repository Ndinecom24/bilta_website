<?php

namespace App\Http\Livewire\Admin\NewsletterPage;

use App\Mail\NewsletterDispatchMail;
use App\Models\Bilta\Newsletter;
use App\Models\NewsletterSubscriber;
use App\Models\System\Status;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShowNewsletters extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $newsletter_id, $title, $short_description, $content, $publish_date, $status_id, $display_order;
    public $newsletter_pdf;
    public $header_image;
    public $newsletter;
    public $showSubscribersList = false;

    public $updateItem = false;
    protected $listeners = [
        'deleteNewsletter' => 'destroy',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'short_description' => 'nullable|string|max:500',
        'content' => 'nullable',
        'publish_date' => 'required|date',
        'status_id' => 'required|exists:statuses,id',
        'display_order' => 'nullable|integer|min:0',
        'newsletter_pdf' => 'nullable|array',
        'newsletter_pdf.*' => 'file|mimes:pdf|max:20480', // 20MB per PDF
        'header_image' => 'nullable|image|max:10240', // 10MB banner image
    ];

    public function render()
    {
        $newsletters = Newsletter::select(
            'id', 'title', 'short_description', 'content', 'publish_date',
            'status_id', 'display_order', 'emails_sent', 'emails_sent_at', 'created_by'
        )
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $statuses = Status::get();
        $subscriberCount = NewsletterSubscriber::count();
        $subscribers = NewsletterSubscriber::select('id', 'email', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.newsletter-page.index')
            ->with(compact('newsletters', 'statuses', 'subscriberCount', 'subscribers'));
    }

    public function toggleSubscribersList()
    {
        $this->showSubscribersList = !$this->showSubscribersList;
    }

    public function store()
    {
        $this->validate();

        try {
            $newsletter = Newsletter::create([
                'title' => $this->title,
                'short_description' => $this->short_description,
                'content' => $this->content,
                'publish_date' => $this->publish_date,
                'status_id' => $this->status_id,
                'display_order' => $this->display_order ?? 0,
                'created_by' => auth()->user()->id,
            ]);

            // Save header/banner image
            if (isset($this->header_image)) {
                $this->compressImage($this->header_image);
                $newsletter->addMedia($this->header_image)
                    ->toMediaCollection('newsletter_header_images');
            }

            // Save PDF attachments
            if (isset($this->newsletter_pdf)) {
                foreach ($this->newsletter_pdf as $pdf) {
                    $newsletter->addMedia($pdf)
                        ->toMediaCollection('newsletter_pdfs');
                }
            }

            // Auto-send emails if status is "approved" (active)
            if ($this->status_id == config('constants.status.active')) {
                $this->dispatchEmails($newsletter);
            }

            session()->flash('success', 'Newsletter created successfully!');
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating newsletter: ' . $e->getMessage());
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $item = Newsletter::findOrFail($id);
        $this->newsletter = $item;
        $this->newsletter_id = $item->id;
        $this->title = $item->title;
        $this->short_description = $item->short_description;
        $this->content = $item->content;
        $this->publish_date = $item->publish_date;
        $this->status_id = $item->status_id;
        $this->display_order = $item->display_order ?? 0;
        $this->updateItem = true;

        $this->dispatchBrowserEvent('load-trix-content', ['content' => $item->content ?? '']);
    }

    public function update()
    {
        $this->validate();

        try {
            $newsletter = Newsletter::findOrFail($this->newsletter_id);
            $previousStatusId = $newsletter->status_id;

            $newsletter->fill([
                'title' => $this->title,
                'short_description' => $this->short_description,
                'content' => $this->content,
                'publish_date' => $this->publish_date,
                'status_id' => $this->status_id,
                'display_order' => $this->display_order ?? 0,
                'created_by' => auth()->user()->id,
            ])->save();

            // Update header/banner image
            if (isset($this->header_image)) {
                $this->compressImage($this->header_image);
                $newsletter->clearMediaCollection('newsletter_header_images');
                $newsletter->addMedia($this->header_image)
                    ->toMediaCollection('newsletter_header_images');
            }

            // Save new PDF attachments
            if (isset($this->newsletter_pdf)) {
                foreach ($this->newsletter_pdf as $pdf) {
                    $newsletter->addMedia($pdf)
                        ->toMediaCollection('newsletter_pdfs');
                }
            }

            // Send emails if status changed to active/approved and not yet sent
            if (!$newsletter->emails_sent
                && $this->status_id == config('constants.status.active')
                && $previousStatusId != config('constants.status.active')
            ) {
                $this->dispatchEmails($newsletter);
            }

            session()->flash('success', 'Newsletter updated successfully!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating newsletter: ' . $e->getMessage());
            $this->cancel();
        }
    }

    public function sendEmails($id)
    {
        try {
            $newsletter = Newsletter::findOrFail($id);

            if ($newsletter->emails_sent) {
                session()->flash('error', 'Emails have already been sent for this newsletter.');
                return;
            }

            if ($newsletter->status_id != config('constants.status.active')) {
                session()->flash('error', 'Newsletter must be active/approved before sending emails.');
                return;
            }

            $this->dispatchEmails($newsletter);
            session()->flash('success', 'Newsletter emails dispatched successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error sending emails: ' . $e->getMessage());
        }
    }

    private function dispatchEmails(Newsletter $newsletter)
    {
        $subscribers = NewsletterSubscriber::all();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(
                new NewsletterDispatchMail($newsletter)
            );
        }

        $newsletter->update([
            'emails_sent' => true,
            'emails_sent_at' => now(),
        ]);
    }

    public function cancel()
    {
        $this->updateItem = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->title = '';
        $this->short_description = '';
        $this->content = '';
        $this->publish_date = '';
        $this->status_id = '';
        $this->display_order = 0;
        $this->newsletter_pdf = null;
        $this->header_image = null;
        $this->newsletter = null;
    }

    public function destroy($id)
    {
        try {
            Newsletter::findOrFail($id)->delete();
            session()->flash('success', 'Newsletter deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting newsletter.');
        }
    }

    public function removeFile($mediaId)
    {
        Media::findOrFail($mediaId)->delete();
        $this->newsletter = Newsletter::find($this->newsletter_id);
        session()->flash('success', 'File removed successfully!');
    }

    /**
     * Compress an uploaded image to 75% quality.
     */
    private function compressImage($uploadedFile)
    {
        try {
            $path = $uploadedFile->getRealPath();
            $image = Image::make($path);

            $mime = $uploadedFile->getMimeType();
            $format = 'jpg';
            if ($mime === 'image/png') {
                $format = 'png';
            } elseif ($mime === 'image/webp') {
                $format = 'webp';
            }

            $image->encode($format, 75)->save($path);
        } catch (\Exception $e) {
            // If compression fails, continue with original file
        }

        return $uploadedFile;
    }
}
