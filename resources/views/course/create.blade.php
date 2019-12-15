@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/autoCompleteAddresses.js') }}"></script>
@endpush

@section('content')
    <course-create-component user='{{ Auth::user() }}'></course-create-component>
@endsection