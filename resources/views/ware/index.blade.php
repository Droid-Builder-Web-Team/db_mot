@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-2 text-left">
                        <a class="btn btn-primary" href={{ route('ware.create') }}>Create Item</a>
                    </div>
                    <div class="col-sm-8 text-center">
                        <h4 class="text-center title">Your Items</h4>
                    </div>
                    <div class="col-sm-2 text-right"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table text-center card-body table-striped table-hover table-dark">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userwares as $ware)
                                <tr>
                                    <td>{{ $ware->type }}</td>
                                    <td><a href="{{ route('ware.show', $ware->id) }}">{{ $ware->title }}</a></td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn-sm btn-xs btn-view" style="color:#FFF;" href="{{ route('ware.show', $ware->id) }}"><i class="fas fa-eye"></i></a>
                                            <a class="btn-sm btn-xs btn-edit" style="color:#FFF;" href="{{ route('ware.edit', $ware->id) }}"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="p-4 card">
			<h4 class="mb-3 text-underline">Caveat Emptor</h4>
			<p>Sales between members are not under the control of Droidbuilders UK. The committee can not be held responsible for any transactions through the marketplace and will not deal with any money exchanges.</p>
            <p>Items listed for free do not include postage unless specified otherwise</p>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-8 text-center">
                        <h4 class="text-center title">Active Items</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table text-center card-body table-striped table-hover table-dark">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Member</th>
                                <th>Country</th>
                                <th>Created</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wares as $ware)
                                @if($ware->user->id != Auth()->user()->id)
                                    <tr>
                                        <td>{{ $ware->type }}</td>
                                        <td><a href="{{ route('ware.show', $ware->id) }}">{{ $ware->title }}</a></td>
                                        <td>{{ $ware->user->forename }} {{ $ware->user->surname }}</td>
                                        <td>{{ $ware->user->country }}</td>
                                        <td>{{ $ware->created_at }}</td>
                                        <td>{{ $ware->updated_at }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn-sm btn-xs btn-view" style="color:#FFF;" href="{{ route('ware.show', $ware->id) }}"><i class="fas fa-eye"></i></a>
                                                @can('Edit Marketplace')
                                                    <a class="btn-sm btn-xs btn-edit" style="color:#FFF;" href="{{ route('ware.edit', $ware->id) }}"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('ware.destroy', $ware->id) }}" method="POST" onsubmit="return confirm('Are You Sure?');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn-sm btn-xs btn-kill action-buttons"><i style="color:#FFF;" class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-8 text-center">
                        <h4 class="text-center title">Old Items</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table text-center card-body table-striped table-hover table-dark">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Member</th>
                                <th>Country</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($oldwares as $ware)
                                <tr>
                                    <td>{{ $ware->type }}</td>
                                    <td><a href="{{ route('ware.show', $ware->id) }}">{{ $ware->title }}</a></td>
                                    <td>{{ $ware->user->forename }} {{ $ware->user->surname }}</td>
                                    <td>{{ $ware->user->country }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn-sm btn-xs btn-view" style="color:#FFF;" href="{{ route('ware.show', $ware->id) }}"><i class="fas fa-eye"></i></a>
                                            @can('Edit Marketplace')
                                                <a class="btn-sm btn-xs btn-edit" style="color:#FFF;" href="{{ route('ware.edit', $ware->id) }}"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('ware.destroy', $ware->id) }}" method="POST" onsubmit="return confirm('Are You Sure?');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn-sm btn-xs btn-kill action-buttons"><i style="color:#FFF;" class="fas fa-trash-alt"></i></button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
