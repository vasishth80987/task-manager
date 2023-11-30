<div>
    <form wire:submit.prevent="save">
        <div class="form-group">
            <label class="font-weight-bold">ID: {{$teamId}}</label>
        </div>

        <div class="form-group">
            <label for="team_lead">Team Lead</label><br>
            <select id="team_lead">
                <option></option>
                @foreach($this->managers as $man)
                    <option value="{{$man->id}}" @if($man->id == $this->team_lead_id) selected @endif>{{$man->name}}</option>
                @endforeach
            </select><br>
            @error('team_lead_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group" wire:ignore>
            <label for="team_members">Team Members</label><br>
            <select id="team_members" multiple>
                @foreach($this->users as $mem)
                    <option value="{{$mem->id}}" @if(in_array($mem->id, $this->team_members)) selected @endif>{{$mem->name}}</option>
                @endforeach
            </select>
        </div>
        <a href="{{ url('/team') }}" class="btn btn-outline-secondary">Go Back</a>
        <button type="submit" class="btn btn-outline-success">{{ $teamId ? 'Update' : 'Create' }}</button>
        <div wire:loading>
            Saving in progress...
        </div>
    </form>
</div>

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#team_members').select2();
            $('#team_members').on('change', function (e) {
                var data = $('#team_members').select2("val");
                @this.set('team_members', data);
            });
            $('#team_lead').select2({
                placeholder: "Select...",
            });
            $('#team_lead').on('select2:select', function (e) {
                var data = $('#team_lead').select2("val");
                @this.set('team_lead_id', data);
            });
        });
    </script>

@endpush

