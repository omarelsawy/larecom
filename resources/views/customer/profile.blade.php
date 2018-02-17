@extends('layouts.app')
@section('title')
    profile
@endsection
@section('content')

<div class="container">

    {!! Form::model($user , ['route' => ['customers.update', $user->id] , 'method' => 'PATCH']) !!}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Name</label>

        <div class="col-md-6">
            {!! Form::text("name" , null , ['class' =>'form-control']) !!}

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Email</label>

        <div class="col-md-6">
            {!! Form::text("email" , null , ['class' =>'form-control']) !!}

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Password</label>

        <div class="col-md-6">
            {!! Form::password("password" , ['class' =>'form-control']) !!}

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-warning">
            <i class="fa fa-btn fa-user"></i>
edit
        </button>
    </div>

    {!! Form::close() !!}


</div>

@endsection