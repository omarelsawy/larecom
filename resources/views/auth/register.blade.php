@extends('layouts.app')
@section('title')
 register
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create an account</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">@lang('register.fname')<sup>*</sup></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contact_name') ? ' has-error' : '' }}">
                            <label for="contact_name" class="col-md-4 control-label">@lang('register.contact')<sup>*</sup></label>

                            <div class="col-md-6">
                                <input id="contact_name" type="text" class="form-control" name="contact_name" value="{{ old('contact_name') }}" required autofocus>

                                @if ($errors->has('contact_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mobile1') ? ' has-error' : '' }}">
                            <label for="mobile1" class="col-md-4 control-label">@lang('register.mob1')<sup>*</sup></label>

                            <div class="col-md-6">
                                <input id="mobile1" type="text" class="form-control" name="mobile1" value="{{ old('mobile1') }}" required autofocus>

                                @if ($errors->has('mobile1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mobile2') ? ' has-error' : '' }}">
                            <label for="mobile2" class="col-md-4 control-label">@lang('register.mob2')<sup>*</sup></label>

                            <div class="col-md-6">
                                <input id="mobile2" type="text" class="form-control" name="mobile2" value="{{ old('mobile2') }}" required autofocus>

                                @if ($errors->has('mobile2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">@lang('register.phone')<sup>*</sup></label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">@lang('register.emailadrress')<sup>*</sup></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">@lang('register.pass')<sup>*</sup></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" autocomplete="new-password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">@lang('register.confpass')<sup>*</sup></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('register.register')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




