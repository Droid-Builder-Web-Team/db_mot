@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-2 text-left">
                        <a class="btn btn-primary" href={{ route('asset.create') }}>Add Asset</a>
                    </div>
                    <div class="col-sm-8 text-center">
                        <h4 class="text-center title">Your Assets</h4>
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
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userassets as $asset)
                                <tr>
                                    <td>{{ $asset->type }}</td>
                                    <td><a href="{{ route('asset.show', $asset->id) }}">{{ $asset->title }}</a></td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn-sm btn-xs btn-view" style="color:#FFF;" href="{{ route('asset.show', $asset->id) }}"><i class="fas fa-eye"></i></a>
                                            <a class="btn-sm btn-xs btn-edit" style="color:#FFF;" href="{{ route('asset.edit', $asset->id) }}"><i class="fas fa-edit"></i></a>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-10 text-center">
                        <h4 class="text-center title">Active Assets</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table text-center card-body table-striped table-hover table-dark">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Owner</th>
                                <th>Current Location</th>
                                <th>Current State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $asset)
                                <tr>
                                    <td>{{ strtoupper($asset->type->value) }}</td>
                                    <td><a href="{{ route('asset.show', $asset->id) }}">{{ $asset->title }}</a></td>
                                    <td>{{ $asset->user->forename }} {{ $asset->user->surname }}</td>
                                    <td>{{ $asset->current_holder->county }}</td>
                                    <td>
                                        @php
                                        $bgcolor = "grey";
                                        $color = "black";
                        
                                        switch ($asset->current_state->value) {
                                          case "new":
                                            $bgcolor = "blue";
                                            $color = "white";
                                            break;
                                          case "good":
                                            $bgcolor = "green";
                                            $color = "white";  
                                            break;
                                          case "worn":
                                            $bgcolor = "yellow";
                                            $color = "grey"; 
                                            break; 
                                          case "damaged":
                                            $bgcolor = "red";
                                            $color = "white";  
                                            break;
                                          case "retired":
                                            $bgcolor = "grey";
                                            $color = "black";  
                                            break;
                                        }
                                      @endphp
                                        <div class="btn-sm" style="background-color: {{ $bgcolor }}; color: {{ $color }}">{{ $asset->current_state }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn-sm btn-xs btn-view" style="color:#FFF;" href="{{ route('asset.show', $asset->id) }}"><i class="fas fa-eye"></i></a>
                                            @can('Edit Marketplace')
                                                <a class="btn-sm btn-xs btn-edit" style="color:#FFF;" href="{{ route('asset.edit', $asset->id) }}"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('asset.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Are You Sure?');" style="display: inline-block;">
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
                Assets are not necessarily property of the club. Some are personally owned by the club member and they are under no obligation to provide access to the asset. 
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-10 text-center">
                        <h4 class="text-center title">Retired Assets</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table text-center card-body table-striped table-hover table-dark">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Owner</th>
                                <th>Current Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($oldassets as $asset)
                                <tr>
                                    <td>{{ $asset->type }}</td>
                                    <td><a href="{{ route('asset.show', $asset->id) }}">{{ $asset->title }}</a></td>
                                    <td>{{ $asset->user->forename }} {{ $asset->user->surname }}</td>
                                    <td>{{ $asset->current_holder->country }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn-sm btn-xs btn-view" style="color:#FFF;" href="{{ route('asset.show', $asset->id) }}"><i class="fas fa-eye"></i></a>
                                            @can('Edit Marketplace')
                                                <a class="btn-sm btn-xs btn-edit" style="color:#FFF;" href="{{ route('asset.edit', $asset->id) }}"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('asset.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Are You Sure?');" style="display: inline-block;">
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
