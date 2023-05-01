<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\HomeIntro;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowHomeIntro extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $our_home_intro_id, $long_description, $name, $short_description, $home_intro;
    public $intro_image;

    public $updateHomeIntro = false;
    protected $listeners = [
        'deleteHomeIntro' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name' => 'required',
        'long_description' => 'required',
        'short_description' => 'required',

        'intro_image' => 'image|max:3072', // 1MB Max

    ];

    public function render()
    {
        $this->home_intro = HomeIntro::select('id', 'name', 'long_description', 'short_description', 'created_by',)->first();

        return view('livewire.admin.home-page.intro.index');
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {

            // Create HomeIntro
            $home_intro = HomeIntro::updateOrCreate(
                [
                    'name' => $this->name,
                    'long_description' => $this->long_description,
                    'short_description' => $this->short_description,
                ],
                [
                    'name' => $this->name,
                    'long_description' => $this->long_description,
                    'short_description' => $this->short_description,
                    'created_by' => auth()->user()->id
                ]

            );

            $home_intro->addMedia($this->intro_image)
                ->toMediaCollection('home_intro_images');

            // Set Flash Message
            session()->flash('success', 'HomeIntro Created Successfully!!');
            // Reset Form Fields After Creating HomeIntro
            $this->resetFields();

        } catch (Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating about us!!' . $e->getMessage());
            // Reset Form Fields After Creating HomeIntro
            $this->resetFields();
        }
    }

    public function resetFields()
    {
        $this->name = '';
        $this->long_description = '';
        $this->short_description = '';
    }

    public function edit($id)
    {
        $our_home_intro = HomeIntro::findOrFail($id);
        $this->home_intro = $our_home_intro;
        $this->name = $our_home_intro->name;
        $this->long_description = $our_home_intro->long_description;
        $this->short_description = $our_home_intro->short_description;
        $this->our_home_intro_id = $our_home_intro->id;
        $this->updateHomeIntro = true;
    }

    public function update()
    {
        // Validate request
        try {
            // Update our_home_intro
            $home_intro = HomeIntro::find($this->our_home_intro_id)->fill(
                [
                    'name' => $this->name,
                    'long_description' => $this->long_description,
                    'short_description' => $this->short_description,
                    'created_by' => auth()->user()->id
                ]
            )->save();

            if (isset($this->intro_image)) {
                $home_intro->clearMediaCollection('home_intro_images');
                $home_intro->addMedia($this->intro_image)
                    ->toMediaCollection('home_intro_images');
            }


            session()->flash('success', 'Home Intro Updated Successfully!!');

            $this->cancel();
        } catch (Exception $e) {
            session()->flash('error', 'Something goes wrong while updating Home Intro!!');
            $this->cancel();
        }
    }

    public function cancel()
    {
        $this->updateHomeIntro = false;
        $this->resetFields();
    }

    public function destroy($id)
    {
        try {
            HomeIntro::find($id)->delete();
            session()->flash('success', "Home Intro Deleted Successfully!!");
        } catch (Exception $e) {
            session()->flash('error', "Something goes wrong while deleting Home Intro!!");
        }
    }

}
