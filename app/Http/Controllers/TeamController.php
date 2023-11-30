<?php

namespace App\Http\Controllers;

use App\DataTables\TeamsDataTable;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Masmerise\Toaster\Toastable;

class TeamController extends Controller
{
    use Toastable;

    /**
     * Constructor to apply middleware for role-based permissions.
     */
    public function __construct()
    {
        // Assign permissions to controller methods
        $this->middleware('permission:view teams')->only(['edit', 'index', 'show']);
        $this->middleware('permission:create teams')->only(['create', 'store']);
        $this->middleware('permission:edit teams')->only(['update']);
        $this->middleware('permission:delete teams')->only('destroy');
    }

    /**
     * Display a listing of teams.
     *
     * @param TeamsDataTable $dataTable
     * @return \Illuminate\View\View
     */
    public function index(TeamsDataTable $dataTable)
    {
        // Display all teams for admin, else display user's teams
        if (auth()->user()->hasRole('admin')) {
            $teams = Team::all()->pluck('id')->toArray();
        } else {
            $teams = auth()->user()->leads->pluck('id')->merge(auth()->user()->teams->pluck('id'))->toArray();
        }

        // Set query for DataTable and render the index view
        $dataTable->setQuery($teams);
        return $dataTable->render('team.index');
    }

    /**
     * Show the form for creating a new team.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        // Authorization check for team creation
        $this->authorize('create', Team::class);

        // Create a new team instance and pass it to the view
        $team = new Team();
        return view('team.create', compact('team'));
    }

    /**
     * Store a newly created team in the database.
     *
     * @param TeamStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TeamStoreRequest $request): RedirectResponse
    {
        // Authorization check for storing new team
        $this->authorize('create', Team::class);

        // Create team with validated data from the request
        $team = Team::create($request->validated());

        // Flash team ID to session
        $request->session()->flash('team.id', $team->id);

        // Redirect to team index route
        return redirect()->route('team.index');
    }

    /**
     * Display the specified team.
     *
     * @param Request $request
     * @param Team $team
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Team $team): View
    {
        // Authorization check for viewing a team
        $this->authorize(['view', 'viewAny'], Team::class);

        // Render the show view with the team
        return view('team.show', compact('team'));
    }

    /**
     * Show the form for editing the specified team.
     *
     * @param Request $request
     * @param Team $team
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Team $team): View
    {
        // Authorization check for editing a team
        $this->authorize('view', $team);

        // Render the edit view with the team
        return view('team.edit', compact('team'));
    }

    /**
     * Update the specified team in the database.
     *
     * @param TeamUpdateRequest $request
     * @param Team $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TeamUpdateRequest $request, Team $team): RedirectResponse
    {
        // Authorization check for updating a team
        $this->authorize('update', $team);

        // Update team with validated data from the request
        $team->update($request->validated());

        // Flash team ID to session
        $request->session()->flash('team.id', $team->id);

        // Redirect to team index route
        return redirect()->route('team.index');
    }

    /**
     * Remove the specified team from the database.
     *
     * @param Request $request
     * @param Team $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Team $team): RedirectResponse
    {
        // Authorization check for deleting a team
        $this->authorize('delete', $team);

        try {
            // Attempt to delete the team
            $team->delete();
            // On successful deletion, log and show success message
            $this->success('Team Deleted');
            Log::channel('app')->notice('Deleted Team:{id}', ['id' => $team->id]);
            // Redirect to team index route
            return redirect()->route('team.index');
        } catch (\Exception $e) {
            // Log any exceptions during deletion and show error message
            Log::debug('An error occurred while deleting team. '.$e->getMessage());
            $team->error('Error deleting team');
            // Redirect to team index route
            return redirect()->route('team.index');
        }
    }
}
