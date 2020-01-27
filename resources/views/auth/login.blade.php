@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center items-center">
        <div class="w-11/12 sm:w-8/12 mx-3 sm:mx-0 shadow-lg rounded overflow-hidden max-w-xl">
            
            <div class="bg-gray-200 text-gray-700 text-2xl font-bold p-3">{{ __('Login') }}</div>    
            
            @error('email')
                <div class="text-center mt-1">
                    <span class="text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            @enderror
            <div class="p-3 sm:p-6">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <label for="email" class="mb-1 sm:text-right sm:mb-0 text-gray-700 font-bold w-full sm:w-4/12">
                            {{ __('E-Mail Address') }}
                        </label>
                        <input id="email" type="email" class="border border-gray-500 px-3 sm:ml-5 font-bold text-base w-full h-10 sm:w-8/12 rounded @error('email') is-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <label for="email" class="mb-1 sm:text-right sm:mb-0 text-gray-700 font-bold w-full sm:w-4/12">
                            {{ __('Password') }}
                        </label>
                        <input id="password" type="password" class="border border-gray-500 px-3 sm:ml-5 font-bold text-base w-full h-10 sm:w-8/12 rounded @error('password') is-error @enderror" name="password" required autocomplete="current-password">
                    </div>
                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <div class="mb-1 sm:mb-0 w-full sm:w-4/12"></div>
                        <div class="w-full sm:w-8/12 sm:ml-5">

                            <div class="block mb-2">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="text-gray-700" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        
                            <button type="submit" class="h-12 mb-5 w-full bg-blue-700 hover:bg-blue-800 font-bold text-white rounded text-2xl shadow-inner">
                                {{ __('Login') }}
                            </button>
                            @if (Route::has('password.request'))
                                <a class="text-blue-400" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection




