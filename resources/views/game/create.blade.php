@extends('layouts.app')

@section('content')
    <game-create-component
        courses="{{$courses}}">
    </game-create-component>
@endsection