@extends('layouts.app')

@section('content')

    <div class="login">
        <div class="header">{{ __('Login') }}</div>

        <div class="body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="box-inner">
                    <label for="email">{{ __('E-Mail Address') }}</label>

                    <div class="box">
                        <input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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
                        <input id="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="box-inner">
                    <div class="box-remember">
                        <input class="check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="box-inner">
                    <div class="box box-submit">
                        <button type="submit">
                            {{ __('Login') }}
                        </button>
                        <div class="link">
                            <a href="{{ route('register') }}">Not register yet?</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
