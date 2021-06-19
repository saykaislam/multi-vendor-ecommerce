<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | MudiHat</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Frontend/img/favicon.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&amp;amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('frontend/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/fonts/Linearicons/Linearicons/Font/demo-files/demo.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/plugins/owl-carousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/plugins/owl-carousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/plugins/slick/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/plugins/nouislider/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/plugins/lightGallery-master/dist/css/lightgallery.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/plugins/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/barikoi/barikoi-js@b6f6295467c19177a7d8b73ad4db136905e7cad6/dist/barikoi.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
          crossorigin="" />
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">

    {{--toastr css--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .twitter-typeahead{
            width: 100% !important;
        }
        .tt-menu{
            width: 100% !important;
            text-align: left!important;
        }
    </style>
    @stack('css')
</head>
<body>
@include('frontend.includes.header')
@yield('content')
@include('frontend.includes.footer')
@include('frontend.includes.footer_2')

<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
{{--<script src="{{asset('frontend/plugins/jquery.min.js')}}"></script>--}}
<script src="{{asset('frontend/js/main.js')}}"></script>
{{--<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>--}}
<script src="{{asset('frontend/plugins/nouislider/nouislider.min.js')}}"></script>
<script src="{{asset('frontend/plugins/popper.min.js')}}"></script>
<script src="{{asset('frontend/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('frontend/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/plugins/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('frontend/plugins/masonry.pkgd.min.js')}}"></script>
<script src="{{asset('frontend/plugins/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('frontend/plugins/jquery.matchHeight-min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>
{{--<script src="{{asset('frotend/plugins/slick/slick/slick.min.js')}}"></script>--}}
<script src="{{asset('frontend/plugins/jquery-bar-rating/dist/jquery.barrating.min.js')}}"></script>
<script src="{{asset('frontend/plugins/slick-animation.min.js')}}"></script>
<script src="{{asset('frontend/plugins/lightGallery-master/dist/js/lightgallery-all.min.js')}}"></script>
<script src="{{asset('frontend/plugins/sticky-sidebar/dist/sticky-sidebar.min.js')}}"></script>
<script src="{{asset('frontend/plugins/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('frontend/plugins/gmap3.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/gh/barikoi/barikoi-js@b6f6295467c19177a7d8b73ad4db136905e7cad6/dist/barikoi.min.js?key:MTg3NzpCRE5DQ01JSkgw"></script>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqEEDdypCvLeSVWqN2JGlQ2pMvCCQKG24&libraries=places">
</script>
@stack('js')

{!! Toastr::message() !!}
<script>
    @if($errors->any())
    @foreach($errors->all() as $error )
    toastr.error('{{$error}}','Error',{
        closeButton:true,
        progressBar:true
    });
    @endforeach
    @endif

    $(document).ready(function() {
        //seach placeholder change
        $('.bksearch').attr("placeholder", "Search your delivery location");
    })
</script>




<!-- custom scripts-->

</body>
</html>
