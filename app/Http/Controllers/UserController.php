<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Masmerise\Toaster\Toastable;

class UserController extends Controller
{
    use Toastable;

    /**
     * Initialize the controller with middleware settings.
     *
     * Only 'admin' role users can access methods in this controller.
     */
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of users.
     *
     * @param UsersDataTable $dataTable
     * @return \Illuminate\View\View
     */
    public function index(UsersDataTable $dataTable)
    {
        // Render the user index view using the DataTables component
        return $dataTable->render('user.index');
    }

    /**
     * Show the form for creating a new user.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request): View
    {
        // Return the view for creating a new user
        return view('user.create');
    }

    /**
     * Store a newly created user in the database.
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        // Create user with validated data from the request
        $user = User::create($request->validated());

        // Flash user ID to session
        $request->session()->flash('user.id', $user->id);

        // Redirect to user index route
        return redirect()->route('user.index');
    }

    /**
     * Display the specified user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(Request $request, User $user): View
    {
        // Return the view for showing user
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, User $user): View
    {
        // Return the view for editing user
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified user in the database.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        // Update user with validated data from the request
        $user->update($request->validated());

        // Flash user ID to session for later use
        $request->session()->flash('user.id', $user->id);

        // Redirect to user index route
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified user from the database.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        try {
            // Attempt to delete the user
            $user->delete();
            // Log successful deletion and show a success message
            $this->success('User Deleted');
            Log::channel('app')->notice('Deleted user:{id}', ['id' => $user->id]);
            // Redirect to user index route
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            // Log any exceptions during deletion and show an error message
            Log::debug('An error occurred while deleting user. '.$e->getMessage());
            $this->error('Error deleting user');
            // Redirect to user index route
            return redirect()->route('user.index');
        }
    }
}
