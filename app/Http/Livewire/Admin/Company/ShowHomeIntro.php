<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\HomeIntro;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowHomeIntro extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $our_home_intro_id, $long_description, $name, $short_description, $home_intro;
    public $intro_image;
    public $slider_images = [];
    public $updateHomeIntro = false;

    protected $listeners = [
        'deleteHomeIntro' => 'destroy'
    ];

    // Validation Rules
    protected $rules = [
        'name' => 'required',
        'long_description' => 'required',
        'short_description' => 'required',
        'intro_image' => 'nullable|image|max:3072',
        'slider_images.*' => 'image|max:4096',

    ];

    private function clearHomeCaches(): void
    {
        cache()->forget('home_intro');
        cache()->forget('home_mission_slider_images');
    }

    public function render()
    {
        $this->home_intro = HomeIntro::first();
        return view('livewire.admin.home-page.intro.index');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'long_description' => 'required',
            'short_description' => 'required',
            'intro_image' => 'required|image|max:3072',
        ]);

        try {
            $home_intro = HomeIntro::first();

            if (!$home_intro) {
                $home_intro = HomeIntro::create([
                    'name' => $this->name,
                    'long_description' => $this->long_description,
                    'short_description' => $this->short_description,
                    'created_by' => auth()->user()->id,
                ]);
            } else {
                $home_intro->fill([
                    'name' => $this->name,
                    'long_description' => $this->long_description,
                    'short_description' => $this->short_description,
                    'created_by' => auth()->user()->id,
                ])->save();
            }

            if ($this->intro_image) {
                $home_intro->clearMediaCollection('home_intro_images');
                $home_intro->addMedia($this->intro_image)->toMediaCollection('home_intro_images');
            }

            $this->clearHomeCaches();
            session()->flash('success', 'Home Intro saved successfully.');
            $this->resetFields();
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong while saving Home Intro.');
            $this->resetFields();
        }
    }

    public function resetFields()
    {
        $this->name = '';
        $this->long_description = '';
        $this->short_description = '';
        $this->intro_image = null;
        $this->slider_images = [];
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
        try {
            HomeIntro::find($this->our_home_intro_id)
                ->fill(
                    [
                        'name' => $this->name,
                        'long_description' => $this->long_description,
                        'short_description' => $this->short_description,
                        'created_by' => auth()->user()->id
                    ]
                )->save();

            $home_intro = HomeIntro::find($this->our_home_intro_id);

            if ($this->intro_image) {
                $home_intro->clearMediaCollection('home_intro_images');
                $home_intro->addMedia($this->intro_image)
                    ->toMediaCollection('home_intro_images');
            }

            $this->clearHomeCaches();
            session()->flash('success', 'Home Intro Updated Successfully!!');
            $this->cancel();
        } catch (Exception $e) {
            session()->flash('error', 'Something goes wrong while updating Home Intro!!');
            $this->cancel();
        }
    }

    public function uploadMissionSliderImages()
    {
        $this->validate([
            'slider_images' => 'required|array|min:1',
            'slider_images.*' => 'image|max:4096',
        ]);

        try {
            $homeIntro = HomeIntro::first();

            if (!$homeIntro) {
                session()->flash('error', 'Please create Home Intro first before uploading slider images.');
                return;
            }

            foreach ($this->slider_images as $image) {
                $homeIntro->addMedia($image)->toMediaCollection('mission_slider_images');
            }

            $this->slider_images = [];
            $this->clearHomeCaches();
            session()->flash('success', 'Mission slider images uploaded successfully.');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to upload mission slider images.');
        }
    }

    public function removeMissionSliderImage($mediaId)
    {
        try {
            $homeIntro = HomeIntro::first();

            if (!$homeIntro) {
                session()->flash('error', 'Home Intro record not found.');
                return;
            }

            $media = $homeIntro->getMedia('mission_slider_images')->firstWhere('id', (int) $mediaId);

            if ($media) {
                $media->delete();
                $this->clearHomeCaches();
                session()->flash('success', 'Mission slider image removed successfully.');
                return;
            }

            session()->flash('error', 'Slider image not found.');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to remove slider image.');
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
            $this->clearHomeCaches();
            session()->flash('success', "Home Intro Deleted Successfully!!");
        } catch (Exception $e) {
            session()->flash('error', "Something goes wrong while deleting Home Intro!!");
        }

    }
}
