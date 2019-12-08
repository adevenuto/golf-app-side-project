@extends('layouts.app')

@section('content')
    <course-index-component user='{{ Auth::user() }}'></course-index-component>
@endsection