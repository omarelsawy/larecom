@extends('layouts.app')

@section('content')
<div class="container">
    <input type="text" id="mapsearch" size="50">
    @if (empty(request()->session()->get('location')))
        <h1>Current location</h1>
    @else
        <h1>location change</h1>
    @endif
    <div id="map" style="width:900px; height:400px"></div>
    <form action="/location" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="lat" id="lat" value="{{getlat()}}">
        <input type="hidden" name="lng" id="lng" value="{{getlng()}}">
        <button type="submit" id="sublocation" class="btn btn-primary">Submit my location</button>
    </form>
</div>
{!! Html::script('js/jquery-1.11.3.min.js')!!}

{{--google map api--}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClrffdjrdDDHn64hxXC18yZDijl90mzTE&libraries=places"></script>

@if (empty(request()->session()->get('location')))
{!! Html::script('/js/map.js')!!}
    @else
    {!! Html::script('/js/editmap.js')!!}
@endif

    @endsection