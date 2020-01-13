@extends('layouts.app')

@section('content')
    <game-show-component course="{{$course}}" holegroups="{{$holegroups}}">
    </game-show-component>
@endsection