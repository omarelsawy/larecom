
var myLatLng;
var map;
var marker;

    geoLocationInit();

    function geoLocationInit() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, fail);
        } else {
            alert("Browser not supported");
        }
    }

    function success(position) {
        var latVal = position.coords.latitude;
        var lngVal = position.coords.longitude;
        //console.log([latVal,lngVal]);
        myLatLng = new google.maps.LatLng(latVal, lngVal);
        createMap(myLatLng);
    }

    function fail() {
        alert("fail find your location");
    }

    //create map
    function createMap(myLatLng) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 15
        });

         marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: true
        });
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
        google.maps.event.addListener(marker , 'dragend' , function () {
             lat = marker.getPosition().lat();
             lng = marker.getPosition().lng();
            $('#lat').val(lat);
            $('#lng').val(lng);
        });
    }

    var searchBox = new google.maps.places.SearchBox(document.getElementById('mapsearch'));
    google.maps.event.addListener(searchBox , 'places_changed' , function () {
       var places = searchBox.getPlaces();
       var bounds = new google.maps.LatLngBounds();
       var i,place;
       for (i=0; place=places[i];i++){
           bounds.extend(place.geometry.location);
           marker.setPosition(place.geometry.location);
       }
       map.fitBounds(bounds);
        map.setZoom(15);
        lat = marker.getPosition().lat();
        lng = marker.getPosition().lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
    });

    $('#sublocation').click(function () {
       alert('done location edit');
    });










