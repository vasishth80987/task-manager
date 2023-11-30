<div>
    <form wire:submit.prevent="save">
        <div class="form-group">
            <label for="name">Name</label>
            <input wire:model="name" type="text" class="form-control" id="name" placeholder="Enter Name">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="name">Email</label>
            <input wire:model="email" type="text" class="form-control" id="email" placeholder="Enter Email">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="name">Password</label>
            <input wire:model="new_password" type="text" class="form-control" id="password" placeholder="Enter New Password">
            @error('new_password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group" wire:ignore>
            <label for="roles">Roles</label><br>
            <select id="roles" multiple>
                @foreach($this->spatie_roles as $role)
                    <option value="{{$role}}" @if(in_array($role, $this->roles)) selected @endif>{{$role}}</option>
                @endforeach
            </select>
        </div>

        <a href="{{ url('/user') }}" class="btn btn-outline-secondary">Go Back</a>
        <button type="submit" class="btn btn-outline-success">{{ $userId ? 'Update' : 'Create' }}</button>
        <div wire:loading>
            Saving in progress...
        </div>
    </form>
</div>


@push('scripts')

    <script>
        $(document).ready(function () {
            $('#roles').select2();
            $('#roles').on('change', function (e) {
                var data = $('#roles').select2("val");
            @this.set('roles', data);
            });
        });
    </script>

@endpush


