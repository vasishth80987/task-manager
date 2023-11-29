<div>
    <form wire:submit.prevent="save">
        <div class="form-group">
            <label for="title">Title</label>
            <input wire:model="title" type="text" class="form-control" id="title" placeholder="Enter title">
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="title">Owner</label>
            <input wire:model="owner" type="text" class="form-control" id="owner" readonly>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea wire:model="description" class="form-control" id="description" placeholder="Enter description"></textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group" wire:ignore>
            <label for="select2">Assignees</label><br>
            <select id="select2" multiple>
                @foreach($this->team_members as $mem)
                    <option value="{{$mem->id}}" @if(in_array($mem->id, $this->assignees)) selected @endif>{{$mem->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:click="$toggle('completion')" class="sr-only peer" @if($completion) checked @endif>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Completed</span>
            </label>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>
        <a href="{{ url('/task') }}" class="btn btn-outline-secondary">Go Back</a>
        <button type="submit" class="btn btn-outline-success">{{ $taskId ? 'Update' : 'Create' }}</button>
    </form>
</div>

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#select2').select2();
            $('#select2').on('change', function (e) {
                var data = $('#select2').select2("val");
                 @this.set('assignees', data);
            });
        });
    </script>

@endpush

