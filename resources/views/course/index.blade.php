@extends('layouts.app')

@section('content')
    <course-index-component user='{{ Auth::user() }}' courses='{{ $courses }}'></course-index-component>
@endsection