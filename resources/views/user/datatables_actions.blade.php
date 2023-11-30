<div class="flex justify-around">
    <a href="{{ route('user.edit', $id) }}" class="btn btn-outline-info">Edit</a>
    <form action="{{ route('user.destroy', $id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</div>
