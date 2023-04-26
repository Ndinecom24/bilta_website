<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\OurTeam;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowLeadershipTeam extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $our_team_id, $details, $name, $position, $email, $phone, $from, $to, $facebook_url, $linkedin_url, $twitter_url, $team;
    public $user_image;

    public $updateLeadershipMember = false;
    protected $listeners = [
        'deleteOurTeam' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name' => 'required',
        'details' => 'required',
        'position' => 'required',
        'email' => 'required',
        'phone' => 'required',

        'user_image' => 'image|max:3072', // 1MB Max

    ];

    public function render()
    {
        $our_teams = OurTeam::select('id', 'name', 'details', 'position', 'email', 'phone', 'created_by',
            'from',
            'to',
            'facebook_url',
            'linkedin_url',
            'twitter_url')->paginate(20);

        return view('livewire.admin.company.our-team.index')->with(compact('our_teams'));
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {

            // Create LeadershipMember
            $team = OurTeam::updateOrCreate(
                [
                    'name' => $this->name,
                    'details' => $this->details,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'position' => $this->position,
                ],
                [
                    'name' => $this->name,
                    'details' => $this->details,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'position' => $this->position,
                    'to' => $this->to,
                    'from' => $this->from,
                    'twitter_url' => $this->twitter_url,
                    'linkedin_url' => $this->linkedin_url,
                    'facebook_url' => $this->facebook_url,
                    'created_by' => auth()->user()->id
                ]

            );

            $team->addMedia($this->user_image)
                ->toMediaCollection('team_images');

            // Set Flash Message
            session()->flash('success', 'LeadershipMember Created Successfully!!');
            // Reset Form Fields After Creating LeadershipMember
            $this->resetFields();

        } catch (Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating about us!!' . $e->getMessage());
            // Reset Form Fields After Creating LeadershipMember
            $this->resetFields();
        }
    }

    public function resetFields()
    {
        $this->name = '';
        $this->details = '';
        $this->position = '';
        $this->email = '';
        $this->phone = '';
        $this->to = '';
        $this->from = '';
        $this->twitter_url = '';
        $this->facebook_url = '';
        $this->linkedin_url = '';
    }

    public function edit($id)
    {
        $our_team = OurTeam::findOrFail($id);
        $this->team = $our_team;
        $this->name = $our_team->name;
        $this->details = $our_team->details;
        $this->email = $our_team->email;
        $this->phone = $our_team->phone;
        $this->position = $our_team->position;
        $this->to = $our_team->to;
        $this->from = $our_team->from;
        $this->twitter_url = $our_team->twitter_url;
        $this->facebook_url = $our_team->facebook_url;
        $this->linkedin_url = $our_team->linkedin_url;
        $this->our_team_id = $our_team->id;
        $this->updateLeadershipMember = true;
    }

    public function update()
    {
        // Validate request
//        $this->validate();
        try {
            // Update our_team
            $team = OurTeam::find($this->our_team_id)->fill(
                [
                    'name' => $this->name,
                    'details' => $this->details,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'position' => $this->position,
                    'to' => $this->to,
                    'from' => $this->from,
                    'twitter_url' => $this->twitter_url,
                    'facebook_url' => $this->facebook_url,
                    'linkedin_url' => $this->linkedin_url,
                    'created_by' => auth()->user()->id
                ]
            )->save();

            if (isset($this->user_image)) {
                $team->clearMediaCollection('team_images');
                $team->addMedia($this->user_image)
                    ->toMediaCollection('team_images');
            }


            session()->flash('success', 'Leadership Member Updated Successfully!!');

            $this->cancel();
        } catch (Exception $e) {
            session()->flash('error', 'Something goes wrong while updating leadership member!!');
            $this->cancel();
        }
    }

    public function cancel()
    {
        $this->updateLeadershipMember = false;
        $this->resetFields();
    }

    public function destroy($id)
    {
        try {
            OurTeam::find($id)->delete();
            session()->flash('success', "Leadership Member Deleted Successfully!!");
        } catch (Exception $e) {
            session()->flash('error', "Something goes wrong while deleting leadership member!!");
        }
    }

}
