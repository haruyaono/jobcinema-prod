@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">ログインしてください。</p>
            <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                {{ csrf_field() }}

                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">次回から省略する</label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            ログイン
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <br>
            <p>
                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}" class="text-center">
                パスワードを忘れましたか？
                </a>
            </p>
            <!-- @if (config('adminlte.register_url', 'register'))
                <p>
                    <a href="{{ url(config('adminlte.register_url', 'register')) }}" class="text-center">
                        {{ trans('adminlte::adminlte.register_a_new_membership') }}
                    </a>
                </p>
            @endif -->
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop
