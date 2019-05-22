@extends('layouts.app')

@section('content')

    <div class="login">
        <div class="header">{{ __('Register') }}</div>

        <div class="body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="box-inner">
                    <label for="name">{{ __('Name') }}</label>

                    <div class="box">
                        <input id="name" type="text" class="{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="box-inner">
                    <label for="email">{{ __('E-Mail Address') }}</label>

                    <div class="box">
                        <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="box-inner">
                    <label for="password">{{ __('Password') }}</label>

                    <div class="box">
                        <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="box-inner">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>

                    <div class="box">
                        <input id="password-confirm" type="password" name="password_confirmation" required>
                    </div>
                </div>

                <div class="box-inner">
                    <div class="box box-submit">
                        <button type="submit">
                            {{ __('Register') }}
                        </button>
                        <div class="link">
                            <a href="{{ route('login') }}">Already have account?</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
