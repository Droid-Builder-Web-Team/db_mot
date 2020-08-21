@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New MOT</h2>
        </div>
    </div>
</div>

<form action="{{ route('admin.mot.store') }}" method="POST">
    @csrf


</form>
@endsection
