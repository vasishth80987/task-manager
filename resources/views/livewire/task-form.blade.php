<div>
    <h3>{{ $taskId ? 'Edit Task' : 'Add New Task' }}</h3>
    <form wire:submit.prevent="save">
        <div class="form-group">
            <label for="title">Title</label>
            <input wire:model="title" type="text" class="form-control" id="title" placeholder="Enter title">
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea wire:model="description" class="form-control" id="description" placeholder="Enter description"></textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ $taskId ? 'Update' : 'Create' }}</button>
    </form>
</div>

