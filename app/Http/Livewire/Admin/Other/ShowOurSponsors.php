<?php

namespace App\Http\Livewire\Admin\Other;

use App\Models\Bilta\Sponsor;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;

class ShowOurSponsors extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $sponsor_id, $website_url, $description, $status_id, $name , $oursponsor ;

    public $sponsor_image , $sponsor_image_update  ;
    public $updateSponsor = false;


    public $showEditSection = false;

    protected $listeners = [
        'deleteOurSponsor' => 'destroy'
    ];

    // Validation Rules
    protected $rules = [
        // 'sponsor' => 'required|sponsor',
        'website_url' => 'required|string|max:255',
        'description' => 'required|string',
        'name' => 'required|string', 
        'sponsor_image' => 'image|max:3072', // 1MB Max
        'sponsor_image_update' => 'nullable|max:3072', // 1MB Max
        ];

    

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $oursponsors = Sponsor::select('*')->paginate(20);
        return view('livewire.admin.sponsor.index', compact('oursponsors', 'statuses'));
    }

    public function resetFields()
    {
        $this->oursponsor = '';
        $this->website_url = '';
        $this->description = '';
        $this->status_id = '';
        $this->name = '';
        $this->recipient = '';
        $this->spam = '';
    }

    public function saveOurSponsor()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create or Update Our Sponsor
            $cSponsor = Sponsor::updateOrCreate(
                [
                    'name' => $this->name,
                    'description' => $this->description,
                    'website_url' => $this->website_url,
                ],
                [
                    'name' => $this->name,
                    'website_url' => $this->website_url,
                    'description' => $this->description,
                    'status_id' => 1,
                    'created_by' => auth()->user()->id,
                ]
            );

            $cSponsor->addMedia($this->sponsor_image)
            ->toMediaCollection('sponsor_image');



            // Set Flash Sponsor
            session()->flash('success', 'Our Sponsor Created Successfully!');
            // Reset Form Fields After Creating OurSponsor
            $this->resetFields();

        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while creating sponsor description: '. $e->getMessage() );
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        $this->oursponsor  =  $sponsor  ;

        $this->website_url = $sponsor->website_url;
        $this->description = $sponsor->description;
        $this->status_id = $sponsor->status_id;
        $this->name = $sponsor->name;
        $this->sponsor_id = $sponsor->id;
        $this->updateSponsor = true;
        $this->sponsor_image = null ;
    }

    public function cancel()
    {
        $this->updateSponsor = false;
        $this->resetFields();
    }

    public function updateOurSponsor()
    {
        // $this->validate();
        try {
           $cSponsor = Sponsor::find($this->sponsor_id)->fill([
              
                'name' => $this->name,
                'website_url' => $this->website_url,
                'description' => $this->description,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id ,
            ])->save();

            if (isset($this->sponsor_image_update)) {
                try {
                    $this->oursponsor ->clearMediaCollection('sponsor_image');
                    $this->oursponsor ->addMedia($this->sponsor_image_update)
                        ->toMediaCollection('sponsor_image');
                    $this->cancel();
                } catch (\Exception $e) {
                    session()->flash('error', 'Something goes wrong while updating  Image !!'. $e->getMessage() );
                }

            }

            session()->flash('success', 'Our Sponsor Updated Successfully!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while updating sponsor description!' . $e->getMessage());
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            Sponsor::find($id)->delete();
            session()->flash('success', "Our Sponsor Deleted Successfully!");
        } catch (\Exception $e) {
            session()->flash('error', "Something went wrong while deleting sponsor description!");
        }
    }


    public function enableEditSection()
    {
        $this->showEditSection = true;
    }

    public function disableEditSection()
    {
        $this->showEditSection = false;
    }


    // Optional: reset page when searching or filtering
    public function updatingSearch()
    {
        $this->resetPage();
    }

}
