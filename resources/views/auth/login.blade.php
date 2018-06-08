@extends('layouts.app', ['include_msg'=>false])
@section('title','Login')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">登录</div>
                    <div class="card-body">
                        <form class="col-md-6" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email" class="control-label">邮箱</label>
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" autofocus>
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password" class="control-label">密码</label>
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password">
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remember"> 记住密码
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                登录
                            </button>
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                忘记密码?
                            </a>
                        </form>
                        <a class="pull-right" style="text-decoration: none" href="{{ route('github.login') }}">
                            使用<i class="fa fa-lg fa-github fa-fw"></i>登录
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
