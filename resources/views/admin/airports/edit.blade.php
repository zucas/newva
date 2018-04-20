@extends('admin.app')
@section('title', "Edit \"$airport->name\"")
@section('content')
<div class="card border-blue-bottom">
   <div class="content">
       {!! Form::model($airport, ['route' => ['admin.airports.update', $airport->id], 'method' => 'patch', 'id' => 'airportForm']) !!}
            @include('admin.airports.fields')
       {!! Form::close() !!}
   </div>
</div>
@endsection
@include('admin.airports.script')
