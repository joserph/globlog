@extends('layouts.principal')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="login-box col-md-6">
            <div class="login-logo">
                <a href="{{ url('/') }}"><b>Sistema </b>Carguera</a>
            </div>
            
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Iniciar Sesión</p>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo Electrónico">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                @if($errors->has('email'))
                                    <span class="error text-danger col-md-12">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @if($errors->has('password'))
                                    <span class="error col-md-12">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="icheck-primary">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember">
                                            <!--{{ __('Remember Me') }}--> Recuerdame
                                        </label>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <button type="submit" class="btn btn-primary btn-block"><!--{{ __('Login') }}--> Iniciar Sesión</button>
                                </div>
                            </div>
                        </form>
                        {{-- @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                <!--{{ __('Forgot Your Password?') }}--> Olvidaste tu contraseña?
                            </a>
                        @endif --}}
                        
                    </div>
            </div>
        </div>
    </div>
</div>
    



@endsection
