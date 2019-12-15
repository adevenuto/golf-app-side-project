@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/autoCompleteCities.js') }}"></script>
@endpush

@section('content')
    <profile-component user='{{ Auth::user() }}'></profile-component>
@endsection
