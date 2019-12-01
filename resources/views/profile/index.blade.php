@extends('layouts.app')

@section('content')
    <profile-component user='{{ Auth::user() }}'></profile-component>
@endsection
