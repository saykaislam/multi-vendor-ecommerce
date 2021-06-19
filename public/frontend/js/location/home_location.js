Bkoi.onSelect(function () {

    let selectedPlace = Bkoi.getSelectedData()
    //console.log(selectedPlace.longitude)
    console.log(selectedPlace.latitude +' : ' +  selectedPlace.longitude)
    var latval = selectedPlace.latitude;
    var lngval = selectedPlace.longitude;
    //alert( latval )
    initializeForMap(latval,lngval)
    searchShops(latval,lngval);
    $('.mapModalShow').modal('hide');


})
/*
$(document).ready(function(){
    //seach placeholder change
    $('.bksearch').attr("placeholder", "Search your delivery location");


    var latval = sessionStorage.getItem("latitude");
    var lngval = sessionStorage.getItem("longitude");
    if(latval==null){
        geoLocationInit();
    }else{
        searchShops(latval,lngval);
    }
});*/

function geoLocationInit() {
    var check_session = sessionStorage.getItem("latitude");
    if(check_session==null){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, fail);
        } else {
            alert("Browser not supported");
        }
    }else{
        let sessionPos = {
            coords: {
                latitude:sessionStorage.getItem("latitude"),
                longitude:sessionStorage.getItem("longitude"),
            },
        };
        //alert()
        success(sessionPos);
        searchShops(sessionStorage.getItem("latitude"),sessionStorage.getItem("longitude"))
    }
}

function success(position) {
    //console.log("in succ");
    sessionStorage.setItem("latitude", position.coords.latitude);
    sessionStorage.setItem("longitude", position.coords.longitude);

    var latval = sessionStorage.getItem("latitude");
    var lngval = sessionStorage.getItem("longitude");
    initializeForMap(latval, lngval)
    fetch(`https://barikoi.xyz/v1/api/search/reverse/MTg3NzpCRE5DQ01JSkgw/geocode?longitude=${lngval}&latitude=${latval}&district=true&post_code=true&country=true&sub_district=true&union=false&pauroshova=false&location_type=true&division=true`)
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => $('#input-search').val(response.place.address))

    fetch(`https://barikoi.xyz/v1/api/search/reverse/MTg3NzpCRE5DQ01JSkgw/geocode?longitude=${lngval}&latitude=${latval}&district=true&post_code=true&country=true&sub_district=true&union=false&pauroshova=false&location_type=true&division=true`)
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => $('#input-search-map').val(response.place.address))

    fetch(`https://barikoi.xyz/v1/api/search/reverse/MTg3NzpCRE5DQ01JSkgw/geocode?longitude=${lngval}&latitude=${latval}&district=true&post_code=true&country=true&sub_district=true&union=false&pauroshova=false&location_type=true&division=true`)
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => $('.address').val(response.place.address))
}
function fail() {
    alert("Please Allow Location For Purchase");
}
/*$('.find').click(function (){
    var latval = sessionStorage.getItem("latitude");
    var lngval = sessionStorage.getItem("longitude");
    if(latval==null){
        return;
    }else{
        searchShops(latval,lngval);
    }

})*/


$('#find2').click(function (){
    //alert('find 2')
    //console.log()
    var latval = $('#txtLat').val();
    var lngval = $('#txtLng').val();
    //alert(latval)
    $('.mapModalShow').modal('hide');
    searchShops(latval,lngval)
})

function searchShops(lat,lng){
    console.log(lat);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/shop/nearest/list',
        method: 'post',
        data: {
            lat:lat,
            lng:lng,
            // service_id:get_service(),
        },
        beforeSend: function(){
            $("#loader").show();
        },
        success: function(data){
            console.log(data);
            $('.shop_list').empty();
            if (data.response.length==0){
                $('.shop_list').empty();
                $('.shop_list').html(`<div class="col-md-12 py-2 px-4 text-center">
                    <h1 class="mt-5 text-danger">No Shop Found!</h1>
                    <img src = "https://icon-library.com/images/found-icon/found-icon-20.jpg" alt = "">
                </div>`);
            }
            else{
                var i;
                 $('.shop_list').empty();
                for(i=0;i<data.response.length;i++){
                    var gname=data.response[i].name;
                    var slug=data.response[i].slug;
                    var imag=data.response[i].logo;
                    var address=data.response[i].address;
                    var base_url =  window.location.origin;
                    var imgPath = base_url+'/'+imag;
                    // fetch('https://barikoi.xyz/v1/api/distance/API_KEY/90.39534587,23.86448886/90.3673,23.8340')
                    //     .then(response => response.json())
                    //     .catch(error => console.error('Error:', error))
                    //     .then(response => console.log('Success:', response))
                    $('.shop_list').append(`<div class="col-md-3 p-2">
                    <figure>
                        <a class="city-tile" data-gtm-cta="findRestaurant_dhaka" href="/shop/${slug}"><picture>
                                <div class="city-picture b-lazy b-loaded" data-src="https://images.deliveryhero.io/image/fd-bd/city-title/city-title-Dhaka.jpg?width=720" style="background-image: url(&quot;${imgPath}">
                                    &nbsp;</div>
                            </picture> <figcaption class="city-info"> <span class="city-name"> ${gname} </span>
                            <span class="text-center"> <h5 class="text-dark">${address}</h5> </span>
                             <span class="city-cta button city__called-action js-ripple"> <svg class="svg-stroke-container mr-4" height="18" viewBox="0 0 20 18" width="20" xmlns="http://www.w3.org/2000/svg"> <g fill="none" fill-rule="evenodd" stroke="#FFFFFF" stroke-linecap="round" stroke-width="2" transform="translate(1 1)"> <path d="M0,8 L17.5,8"></path> <polyline points="4.338 13.628 15.628 13.628 15.628 2.338" stroke-linejoin="round" transform="rotate(-45 9.983 7.983)"></polyline> </g> </svg> </span> </figcaption> </a></figure>
                </div>`);
                    //For list
                }
            }
        },
        complete:function(){
            $("#loader").hide();
            $('html, body').animate({
                scrollTop: $(".jump").offset().top
            }, 500);
        }
    });
}

function initializeForMap(lat, lng) {
    //alert(lat)
    $("#txtLat").val(lat);
    $("#txtLng").val(lng);
    // Creating map object
    /*var lat = sessionStorage.getItem("latitude");
    var lng = sessionStorage.getItem("longitude");*/
    var map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 12,
        center: new google.maps.LatLng(lat, lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    // creates a draggable marker to the given coords
    var vMarker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),
        draggable: true
    });
    // adds a listener to the marker
    // gets the coords when drag event ends
    // then updates the input with the new coords
    google.maps.event.addListener(vMarker, 'dragend', function (evt) {
        $("#txtLat").val(evt.latLng.lat().toFixed(7));
        $("#txtLng").val(evt.latLng.lng().toFixed(7));
        map.panTo(evt.latLng);
        BarikoiPlaceFetch(evt.latLng.lng().toFixed(7), evt.latLng.lat().toFixed(7))
    });
    // centers the map on markers coords
    map.setCenter(vMarker.position);
    // adds the marker on the map
    vMarker.setMap(map);

}

function BarikoiPlaceFetch(lngval, latval){
   // alert(latval+' : '+lngval )
    fetch(`https://barikoi.xyz/v1/api/search/reverse/MTg3NzpCRE5DQ01JSkgw/geocode?longitude=${lngval}&latitude=${latval}&district=true&post_code=true&country=true&sub_district=true&union=false&pauroshova=false&location_type=true&division=true`)
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        //.then(response => alert(response.place.address))
        .then(response => $('.input-search-map').val(response.place.address))
}


function mapModalClick(){
    //alert('okkkkk')
    geoLocationInit()
    $('.mapModalShow').modal('show');


}
