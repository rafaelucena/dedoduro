@extends('layouts.front')

@section('content')
    <div class="crt-container-sm">
        <div id="contact" class="crt-paper-layers crt-animate">
            <div class="crt-paper clearfix">
                <div class="crt-paper-cont paper-padd clear-mrg">
                    <div class="padd-box">
                        <div class="padd-box-sm">
                            <form action="{{ route('login') }}" method="post" class="contact-form" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('POST') }}

                                <div class="form-group">
                                    <label class="form-label" for="email">E-mail</label>
                                    <div class="form-item-wrap">
                                        <input id="email" name="email" type="email" required="required"
                                               class="form-item{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               autocomplete="email" value="{{ old('email') }}"/>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="password">Senha</label>
                                    <div class="form-item-wrap">
                                        <input id="password" type="password" name="password" required="required"
                                               class="form-item{{ $errors->has('password') ? ' is-invalid' : '' }}"/>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="password">Remember Me</label>
                                    <div class="form-item-wrap">
                                        <input id="remember" class="form-item" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="form-submit form-item-wrap">
                                    {{--<input class="btn btn-default btn-lg" type="submit" value="Logar">--}}
                                    <button type="submit" class="btn btn-primary">
                                        Logar
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Esqueceu sua senha?
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div><!-- .padd-box -->
                </div>
                <!-- .crt-paper-cont -->
            </div>
            <!-- .crt-paper -->
        </div>
        <!-- .crt-paper-layers -->
    </div>
    <!-- .crt-container-sm -->
@endsection