<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserForm extends Component
{
    // Using Laravel's authorization trait
    use AuthorizesRequests;

    // Public properties for user form
    public $user;
    public $userId;
    public $name;
    public $email;
    public $password;
    public $new_password;
    public $roles;
    public $spatie_roles;

    // Validation rules for user fields
    protected $rules = [
        'name' => 'string|max:255',
        'email' => 'required|email',
        'new_password' => 'min:8'
    ];

    /**
     * Mount component and populate the component's properties.
     *
     * @param User|null $user The user to be edited, null if creating a new user.
     */
    public function mount(User $user = null)
    {
        // Initializes user details if editing an existing user
        if ($user) {
            $this->user = $user;
            // Admin role check for editing users
            if (!auth()->user()->hasRole('admin')) {
                throw UnauthorizedException::forRolesOrPermissions(['admin']);
            }
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = $user->password;
            $this->new_password = '';
            $this->roles = $user->roles->pluck('name')->toArray();
            $this->spatie_roles = $roles = \Spatie\Permission\Models\Role::all()->pluck('name');
        }
    }

    /**
     * Handles saving and updating of user data.
     * Includes validation, authorization, and error handling.
     */
    public function save()
    {
        // Admin role check for saving user details
        if (!auth()->user()->hasRole('admin')) {
            throw UnauthorizedException::forRolesOrPermissions(['admin']);
        }

        $this->validate(); // Validate input
        $this->sanitize(); // Sanitize input

        try {
            // Create or update user details
            $user = User::updateOrCreate(['id' => $this->userId], [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->new_password ? Hash::make($this->new_password) : $this->password
            ]);

            //update user roles
            $user->roles()->detach();
            foreach($this->roles as $role) $user->assignRole($role);

            // Dispatch event and show success message
            $this->dispatch('userSaved');
            Toaster::success('User Saved!');
            Log::channel('app')->notice('Updated user:{id}', ['id' => $user->id]);

            // Redirect if creating a new user
            if (empty($this->user->id))
                redirect()->to('/user');
        } catch (\Exception $e) {
            // Log errors and show error message
            Log::debug('An error occurred while saving user. '.$e->getMessage());
            Toaster::error('Could not save user! Check logs for more info.');
        }
    }

    /**
     * Sanitizes the name and email input fields
     */
    public function sanitize()
    {
        $this->name = filter_var($this->name, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
    }

    /**
     * Renders the UserForm view.
     *
     * @return \Illuminate\View\View The view to be rendered.
     */
    public function render()
    {
        return view('livewire.user-form');
    }
}
