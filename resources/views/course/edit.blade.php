@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/autoCompleteAddresses.js') }}"></script>
@endpush

@section('content')
    <course-edit-component course="{{$course}}" holegroups="{{$holegroups}}"></course-edit-component>
@endsection