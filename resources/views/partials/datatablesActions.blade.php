    <a class="btn btn-xs btn-primary" href="{{ route($crudRoutePart . '.show', $row->id) }}">
        View
    </a>
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . 's.edit', $row->id) }}">
        Edit
    </a>
    <form action="{{ route('admin.' . $crudRoutePart . 's.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Are You Sure?');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
    </form>
