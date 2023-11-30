<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\TeamAssigned;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Team;
use Masmerise\Toaster\Toaster;

class TeamForm extends Component
{
    use AuthorizesRequests;

    // Public properties for team and user information
    public $team;
    public $teamId;
    public $users;
    public $managers;
    public $team_members;
    public $team_members_old;
    public $team_lead_id;

    // Validation rules for the team form
    protected $rules = [
        'team_lead_id' => 'required'
    ];

    /**
     * Lifecycle hook that runs when the component is initialized.
     * Populates the component's properties if an existing team is provided.
     *
     * @param Team|null $team The team to be edited, null if creating a new team.
     */
    public function mount(Team $team = null)
    {
        // Checks if an existing team is provided and initializes properties
        if ($team) {
            $this->team = $team;
            $this->teamId = $team->id;
            $this->team_lead_id = $team->team_lead_id;
            $this->team_members_old = $team->teamMembers()->pluck('user_id')->all();
            $this->team_members = $team->teamMembers()->pluck('user_id')->all();
            $this->users = User::all(['id','name']);
            $this->managers = User::role('manager')->get();
        }
    }

    /**
     * Handles saving and updating of team data.
     * Includes validation, authorization, and error handling.
     */
    public function save()
    {
        // Authorizes based on whether it's a new team or an existing one
        $this->authorize($this->team->id == null ? 'create' : 'update', $this->team);

        $this->validate(); // Validates input against defined rules

        try {
            $create = !$this->teamId; // Flag for new team creation

            // Handle team creation or updating
            $team = Team::updateOrCreate(['id' => $this->teamId], [
                'team_lead_id' => $this->team_lead_id
            ]);

            // Syncs team members and notifies new members
            $new_members = array_diff($this->team_members,$this->team_members_old);
            $team->teamMembers()->sync($this->team_members);

            $this->dispatch('teamSaved');
            Toaster::success('Team Saved!');
            Log::channel('app')->notice('Updated Team:{id}', ['id' => $team->id]);

            //notify members
            if(count($new_members)){
                Toaster::info('Notifications sent via email');
                Notification::send(User::find($new_members), new TeamAssigned($team));
            }
            if($create)
                redirect()->to('/team');
        } catch (\Exception $e) {
            Log::debug('An error occurred while saving team. '.$e->getMessage());
            Toaster::error('Could not save Team! Check logs for more info.');
        }
    }

    /**
     * Renders the TeamForm view.
     *
     * @return \Illuminate\View\View The view to be rendered.
     */
    public function render()
    {
        return view('livewire.team-form');
    }
}

