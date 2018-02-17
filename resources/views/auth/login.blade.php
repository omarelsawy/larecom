@extends('layouts.app')
@section('title')
    login
@endsection
@section('content')
    <div id="breadcrumb" class="clearfix">
        <div class="container">
            <div class="breadcrumb clearfix">
                <h2 class="bread-title">@lang('login.login')</h2>
                <ul class="ul-breadcrumb">
                    <li><a href="index.html" title="Home">Home</a></li>
                    <li><span>Pages</span></li>
                </ul>
            </div>
        </div>
    </div><!-- end breadcrumb -->
    <div id="columns" class="columns-container">
        <!-- container -->
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <form action="#" id="create-account-form" class="form-horizontal box panel panel-default">
                        <h3 class="panel-heading">@lang('login.create')</h3>
                        <div class="form_content panel-body clearfix">
                            <p>Registration is quick and easy. It allows you to be able to order from our shop. To start shopping click register.</p>
                            <a href="{{ route('register') }}" class="btn button btn-default" title="Create an account" rel="nofollow"><i class="fa fa-user left"></i>@lang('login.createaccount')</a>
                        </div>
                    </form><!--end form -->
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('login') }}" id="form-login" class="form-horizontal box panel panel-default" method="post">
                        {{ csrf_field() }}
                        <h3 class="panel-heading">@lang('login.alreadyreg')?</h3>
                        <div class="form_content panel-body clearfix">
                            <div class="form-group"{{ $errors->has('email') ? ' has-error' : ''}}>
                                <div class="col-lg-12">
                                    <label for="email">@lang('login.email')</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group"{{ $errors->has('password') ? ' has-error' : '' }}>
                                <div class="col-lg-12">
                                    <label for="passwd">@lang('login.pass')</label>
                                    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <p class="lost_password">
                                        <a href="{{ route('password.request') }}" title="Recover your forgotten password" rel="nofollow">@lang('login.forgot')?</a>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <button class="btn button btn-default"><i class="fa fa-lock left"></i>@lang('login.sign')</button>
                                </div>
                            </div>
                        </div>
                    </form><!--end form -->
                </div>
            </div>
        </div> <!-- end container -->
    </div><!--end warp-->

            </div>
        </div>
    </div>
</div>
@endsection


