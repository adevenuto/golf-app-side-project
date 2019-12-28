@extends('layouts.app')

@section('content')
    <div id="coursesIndex" class="container">
        <div class="row">
            @forelse ($courses as $course)
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="img-wrapper">
                            <img class="card-img-top" src="https://teetyme-app.s3.us-east-2.amazonaws.com/{{$course->featured_image}}" alt="course image">
                            @if (Auth::check())
                                <div class="favorites">
                                    <favorite-component 
                                        course_id="{{$course->id}}"
                                        favorited="{{$course->favorited()}}"
                                    ><favorite-component>
                                </div>
                            @endif
                        </div>
                        @if (Auth::check())
                            <a href="/course/edit/{{$course->id}}" class="edit-course-link text-center">
                                Edit
                            </a>
                        @endif
                        <div class="card-body p-2">
                            <h5 class="card-title">{{ $course->course_name }}</h5>
                        </div>
                    </div>
                </div>
                @empty 
                <p>No Courses</p>
            @endforelse
        </div>
    </div>
@endsection

