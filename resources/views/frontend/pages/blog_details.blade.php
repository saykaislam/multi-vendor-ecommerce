@extends('frontend.layouts.master')
@section('title', $blog->title)
@section('content')
    <div class="ps-page--blog">
        <div class="ps-post--detail ps-post--parallax">
            <div class="ps-post__header bg--parallax" data-background="{{asset('frontend/img/blog-banner.jpg')}}" style="height: 100px">
                <div class="container" style="margin-top: -40px">
                    <h1>{{$blog->title}}</h1>
                </div>
            </div>
            <div class="container">
                <div class="ps-post__content">
                    <img class="mb-30" src="{{url($blog->image)}}" alt="">
                    <h4>{{$blog->title}}</h4>
                    <p class="text-justify">{!! $blog->description !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection



