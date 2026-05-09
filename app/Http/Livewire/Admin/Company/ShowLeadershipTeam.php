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

    public $our_team_id, $details, $name, $position, $display_order, $email, $phone, $from, $to, $facebook_url, $linkedin_url, $twitter_url, $team;
    public $user_image;

    public $updateLeadershipMember = false;
    protected $listeners = [
        'deleteOurTeam' => 'destroy',
        'reorderTeam' => 'reorderTeam',
    ];
    // Validation Rules
    protected $rules = [
        'name' => 'required',
        'details' => 'required',
        'position' => 'required',
        'display_order' => 'nullable|integer|min:0',
        'email' => 'required',
        'phone' => 'required',
        // 'user_image' => 'required|mimes:png,jpg,jpeg|max:3072', // 3MB Max,
        'user_image' => 'image|max:3072', // 1MB Max

    ];

    public function render()
    {
        $our_teams = OurTeam::select(
            'id',
            'name',
            'details',
            'position',
            'display_order',
            'email',
            'phone',
            'created_by',
            'from',
            'to',
            'facebook_url',
            'linkedin_url',
            'twitter_url'
        )
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

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
                    'display_order' => $this->display_order ?? 0,
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
        $this->display_order = 0;
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
        $this->display_order = $our_team->display_order ?? 0;
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
                    'display_order' => $this->display_order ?? 0,
                    'to' => $this->to,
                    'from' => $this->from,
                    'twitter_url' => $this->twitter_url,
                    'facebook_url' => $this->facebook_url,
                    'linkedin_url' => $this->linkedin_url,
                    'created_by' => auth()->user()->id
                ]
            )->save();

            $team = OurTeam::find($this->our_team_id);
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

    public function reorderTeam($orderedIds)
    {
        if (!is_array($orderedIds) || count($orderedIds) === 0) {
            return;
        }

        $orderedIds = array_values(array_filter($orderedIds, function ($id) {
            return is_numeric($id);
        }));

        if (count($orderedIds) === 0) {
            return;
        }

        $currentBatch = OurTeam::whereIn('id', $orderedIds)->get(['id', 'display_order']);
        if ($currentBatch->isEmpty()) {
            return;
        }

        $startOrder = (int) $currentBatch->min('display_order');
        if ($startOrder < 1) {
            $startOrder = 1;
        }

        foreach ($orderedIds as $index => $id) {
            OurTeam::where('id', $id)->update([
                'display_order' => $startOrder + $index,
            ]);
        }

        session()->flash('success', 'Team order updated successfully.');
    }

}
