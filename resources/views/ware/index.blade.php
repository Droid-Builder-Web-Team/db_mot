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
                All my items
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
                        <h4 class="text-center title">All Items</h4>
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
                                <th>Member</th>
                                <th>Country</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wares as $ware)
                                <tr>
                                    <td>{{ $ware->type }}</td>
                                    <td><a href="{{ route('ware.show', $ware->id) }}">{{ $ware->title }}</a></td>
                                    <td>{{ $ware->user->forename }} {{ $ware->user->surname }}</td>
                                    <td>{{ $ware->user->country }}</td>
                                    <td>
                                        <div class="d-flex">
                                          <a class="btn btn-view" href={{ route('ware.show', $ware->id) }}><div class="d-block d-sm-none"><i class="fas fa-eye"></i></div><span class="d-none d-sm-block">View</span></a>
                                          @if(Auth()->user()->id == $ware->user->id)
                                            <a class="btn btn-edit" href={{ route('ware.edit', $ware->id) }}><div class="d-block d-sm-none"><i class="fas fa-edit"></i></div><span class="d-none d-sm-block">Edit</span></a>
                                          @endif
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
