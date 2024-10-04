@extends('layout')

@section('content')
    <style>

        .forgot_button{
            height: 45px;
            width: 150px;
            text-align: center;
            line-height: 45px;
            margin-right: 0;
            border-radius: 40px;
            background: #52616D;
            color: #fff;
        }
        
    </style>
    <!-- Resources -->
    <div style="width: 360px;
    margin: 12% auto;">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ url('/password/email') }}" method="post">
                    {!! csrf_field() !!}
                    <span>Enter email address</span>
                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="email" name="email" class="form-control" value="{{ isset($email) ? $email : old('email') }}"
                               placeholder="{{ trans('adminlte::adminlte.email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                            <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button type="submit"
                            class="forgot_button"
                    >Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>

@endsection
