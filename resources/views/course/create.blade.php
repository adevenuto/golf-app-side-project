@extends('layouts.app')

@section('content')
    <course-create-component user='{{ Auth::user() }}'></course-create-component>
@endsection