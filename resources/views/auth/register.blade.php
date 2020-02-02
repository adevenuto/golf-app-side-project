@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center items-center">
        <div class="w-11/12 sm:w-8/12 mx-3 sm:mx-0 shadow-lg rounded overflow-hidden max-w-xl">
            <div class="bg-gray-200 text-gray-700 text-2xl font-bold p-3">{{ __('Register') }}</div>    
            @error('email')
                <div class="text-center mt-1">
                    <span class="text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            @enderror
            @error('password')
                <div class="text-center mt-1">
                    <span class="text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            @enderror
            <div class="p-3 sm:p-6">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <label class="mb-1 sm:text-right sm:mb-0 text-gray-700 font-bold w-full sm:w-4/12">
                            {{ __('First name') }}
                        </label>
                        <input type="text" class="border border-gray-500 px-3 sm:ml-5 font-bold text-base w-full h-10 sm:w-8/12 rounded outline-none focus:outline-none focus:border-blue-800 @error('first_name') is-error @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                    </div>

                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <label class="mb-1 sm:text-right sm:mb-0 text-gray-700 font-bold w-full sm:w-4/12">
                            {{ __('Last name') }}
                        </label>
                        <input type="text" class="border border-gray-500 px-3 sm:ml-5 font-bold text-base w-full h-10 sm:w-8/12 rounded outline-none focus:outline-none focus:border-blue-800 @error('last_name') is-error @enderror" name="last_name" required autocomplete="last_name">
                    </div>

                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <label for="email" class="mb-1 sm:text-right sm:mb-0 text-gray-700 font-bold w-full sm:w-4/12">
                            {{ __('E-Mail Address') }}
                        </label>
                        <input id="email" type="email" class="border border-gray-500 px-3 sm:ml-5 font-bold text-base w-full h-10 sm:w-8/12 rounded outline-none focus:outline-none focus:border-blue-800 @error('email') is-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>

                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <label for="email" class="mb-1 sm:text-right sm:mb-0 text-gray-700 font-bold w-full sm:w-4/12">
                            {{ __('Password') }}
                        </label>
                        <input id="password" type="password" class="border border-gray-500 px-3 sm:ml-5 font-bold text-base w-full h-10 sm:w-8/12 rounded outline-none focus:outline-none focus:border-blue-800 @error('password') is-error @enderror" name="password" required autocomplete="new-password">
                    </div>

                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <label for="email" class="mb-1 sm:text-right sm:mb-0 text-gray-700 font-bold w-full sm:w-4/12">
                            {{ __('Confirm password') }}
                        </label>
                        <input id="password" type="password" class="border border-gray-500 px-3 sm:ml-5 font-bold text-base w-full h-10 sm:w-8/12 rounded outline-none focus:outline-none focus:border-blue-800 @error('password') is-error @enderror" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="flex flex-col py-2 mt-4 items-center sm:flex-row">
                        <div class="mb-1 sm:mb-0 w-full sm:w-4/12"></div>
                        <div class="w-full sm:w-8/12 sm:ml-5">

                            <button type="submit" class="h-12 w-full bg-blue-700 hover:bg-blue-800 font-bold text-white rounded text-2xl shadow-inner">
                                {{ __('Register') }}
                            </button>
                        
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
