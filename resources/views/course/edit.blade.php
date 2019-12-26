@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/autoCompleteAddresses.js') }}"></script>
@endpush

@section('content')
    <course-edit-component course="{{$course}}"></course-edit-component>
@endsection