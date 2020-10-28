@extends('layout')

@section('title',__('Login'))

@section('content')
<section id="cover" class="min-vh-100">
    <div id="cover-caption">
        <div class="container">
        <div class="row text-white">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
            <h1 class="display-4 py-2 text-truncate">{{ __('Notes') }}</h1>
            <div class="px-2">
            <form action="{{ route('login') }}" class="justify-content-center" method="POST">
                @csrf
                <div class="form-group">
                    <label class="sr-only">{{ __('Email adress') }}</label>
                    <input type="email" class="form-control @error('email')is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('Email adress') }}" required autofocus autocomplete="email">
                </div>
                <div class="form-group">
                    <label class="sr-only">{{ __('Password') }}</label>
                    <input type="password" class="form-control @error('email')is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
                    @error('email')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">{{ __('Login') }}</button>
            </form>
            <hr />
            {{ __('Please login to gain access for editing!') }}
            </div>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection