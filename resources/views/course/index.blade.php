@extends('layouts.app')

@section('content')
    <div class="container sm:mx-auto">
        <div class="flex flex-wrap">
            @forelse ($courses as $course)

                <div class="w-full my-2 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6">
                    <div class="w-11/12 mx-auto relative shadow-lg">
                        <img class="h-64 sm:h-48 object-cover rounded-t w-full" src="https://teetyme-app.s3.us-east-2.amazonaws.com/{{$course->featured_image}}" alt="course image">

                        @if (Auth::check())
                            
                            <div class="absolute bg-white p-2 top-0 mt-3 right-0 mr-3 bg-white-opacity-7 items-center rounded">


                                <div class="z-10 flex">
                                    <template>
                                        <favorite-component 
                                            course_id="{{$course->id}}"
                                            favorited="{{$course->favorited()}}"
                                        ><favorite-component>
                                    </template>
                                    <template>
                                        <a href="/course/edit/{{$course->id}}" class="text-sm text-gray-200 hover:text-white ml-3 font-bold bg-gray-700 px-2 rounded shadow">
                                            Edit
                                        </a>
                                    </template>
                                </div>
                        

                            </div>
                            
                        @endif
                        
                        <div class="p-3">
                            <div class="text-xl h-20 b">
                                {{ $course->course_name }}   
                            </div>
                        </div>
                    </div>
                </div>
                @empty 
                <p>No Courses</p>
            @endforelse
        </div>
    </div>
@endsection

