<?php

namespace App\Http\Livewire\Admin\PrayerPointsPage;

use App\Models\Bilta\WeeklyPrayerPoints;
use App\Models\System\Status;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShowPrayerPoints extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $weekly_prayer_point_id, $details, $title, $status_id, $post_date, $scriptures;

    public $banner_image;
    public $attachments = [];

    public $prayerPoint;
    public $updateWeeklyPrayerPoint = false;

    protected $listeners = [
        'deleteWeeklyPrayerPoint' => 'destroy'
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'status_id' => 'required|exists:statuses,id',
        'post_date' => 'required|date',
        'details' => 'nullable|string',
        'scriptures' => 'nullable|string',
        'banner_image' => 'nullable|image|max:5120',
        'attachments' => 'nullable|array',
        'attachments.*' => 'file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
    ];

    public function render()
    {
        $statuses = Status::all();
        $weekly_prayer_points = WeeklyPrayerPoints::with('media')
            ->orderBy('post_date', 'desc')
            ->paginate(20);

        return view('livewire.admin.prayer-points-page.index')
            ->with(compact('weekly_prayer_points', 'statuses'));
    }

    public function resetFields()
    {
        $this->title = '';
        $this->details = '';
        $this->status_id = '';
        $this->post_date = '';
        $this->scriptures = '';
        $this->banner_image = null;
        $this->attachments = [];
        $this->prayerPoint = null;
    }

    public function store()
    {
        $this->validate();

        try {
            $date = date_parse_from_format('Y-m-d', $this->post_date);

            $prayerPoint = WeeklyPrayerPoints::create([
                'title' => $this->title,
                'details' => $this->details,
                'post_date' => $this->post_date,
                'scriptures' => $this->scriptures,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id,
                'year' => $date['year'],
                'month' => $date['month'],
                'week' => date("W", strtotime($this->post_date)),
                'day' => $date['day'],
            ]);

            // Save banner image
            if (isset($this->banner_image)) {
                $this->compressImage($this->banner_image);
                $prayerPoint->addMedia($this->banner_image)
                    ->toMediaCollection('prayer_banner_images');
            }

            // Save PDF / image attachments
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $file) {
                    $mime = $file->getMimeType();
                    if (str_starts_with($mime, 'image/')) {
                        $this->compressImage($file);
                    }
                    $prayerPoint->addMedia($file)
                        ->toMediaCollection('prayer_attachments');
                }
            }

            session()->flash('success', 'Prayer Point created successfully!');
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating prayer point: ' . $e->getMessage());
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $item = WeeklyPrayerPoints::findOrFail($id);
        $this->prayerPoint = $item;
        $this->weekly_prayer_point_id = $item->id;
        $this->title = $item->title;
        $this->details = $item->details;
        $this->post_date = $item->post_date;
        $this->scriptures = $item->scriptures;
        $this->status_id = $item->status_id;
        $this->updateWeeklyPrayerPoint = true;
    }

    public function cancel()
    {
        $this->updateWeeklyPrayerPoint = false;
        $this->resetFields();
    }

    public function update()
    {
        $this->validate();

        try {
            $date = date_parse_from_format('Y-m-d', $this->post_date);
            $prayerPoint = WeeklyPrayerPoints::findOrFail($this->weekly_prayer_point_id);

            $prayerPoint->fill([
                'title' => $this->title,
                'details' => $this->details,
                'post_date' => $this->post_date,
                'scriptures' => $this->scriptures,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id,
                'year' => $date['year'],
                'month' => $date['month'],
                'week' => date("W", strtotime($this->post_date)),
                'day' => $date['day'],
            ])->save();

            // Update banner image
            if (isset($this->banner_image)) {
                $this->compressImage($this->banner_image);
                $prayerPoint->clearMediaCollection('prayer_banner_images');
                $prayerPoint->addMedia($this->banner_image)
                    ->toMediaCollection('prayer_banner_images');
            }

            // Add new attachments
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $file) {
                    $mime = $file->getMimeType();
                    if (str_starts_with($mime, 'image/')) {
                        $this->compressImage($file);
                    }
                    $prayerPoint->addMedia($file)
                        ->toMediaCollection('prayer_attachments');
                }
            }

            session()->flash('success', 'Prayer Point updated successfully!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating prayer point: ' . $e->getMessage());
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            WeeklyPrayerPoints::findOrFail($id)->delete();
            session()->flash('success', 'Prayer Point deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting prayer point.');
        }
    }

    public function removeFile($mediaId)
    {
        Media::findOrFail($mediaId)->delete();
        $this->prayerPoint = WeeklyPrayerPoints::find($this->weekly_prayer_point_id);
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
