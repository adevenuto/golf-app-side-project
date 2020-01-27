@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center items-center">
        <div class="w-11/12 sm:w-8/12 mx-3 sm:mx-0 shadow-lg rounded overflow-hidden max-w-xl">
            
            <div class="bg-gray-200 text-gray-700 text-2xl font-bold p-3">{{ __('Reset Password') }}</div>    
            @if (session('status'))
                <div class="p-2 bg-green-300 text-green-800 font-bold mx-3 mt-3 rounded" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @error('email')
                <div class="text-center mt-1">
                    <span class="text-red-500" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            @enderror
            <div class="p-3 sm:p-6">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <label for="email" class="mb-1 sm:text-right sm:mb-0 text-gray-700 font-bold w-full sm:w-4/12">
                            {{ __('E-Mail Address') }}
                        </label>
                        <input id="email" type="email" class="border border-gray-500 px-3 sm:ml-5 font-bold text-base w-full h-10 sm:w-8/12 rounded outline-none focus:outline-none focus:border-blue-800 @error('email') is-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                
                    <div class="flex flex-col py-2 items-center sm:flex-row">
                        <div class="mb-1 sm:mb-0 w-full sm:w-4/12"></div>
                        <div class="w-full sm:w-8/12 sm:ml-5">

                            <button type="submit" class="h-12 mb-5 w-full bg-blue-700 hover:bg-blue-800 font-bold text-white rounded text-2xl shadow-inner">
                                {{ __('Send Password Reset Link') }}
                            </button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
