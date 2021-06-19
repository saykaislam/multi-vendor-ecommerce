@extends('frontend.layouts.master')
@section('title', 'User Profile')
@section('content')
    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>User Information</li>
                </ul>
                {{--                <div class="text-right">Logout</div>--}}
            </div>
        </div>
        <section class="ps-section--account">
            <div class="container">
                <div class="row">
                    @include('frontend.user.includes.user_sidebar')
                    <div class="col-lg-9">
                        <div class="ps-section__right">
                            <form class="ps-form--account-setting" action="{{route('user.profile-update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="ps-form__header">
                                    <h3> User Information</h3>
                                </div>
                                <div class="ps-form__content">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" name="name" value="{{ Auth::User()->name }}" placeholder="Please enter your name...">
                                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input class="form-control" type="number" name="phone" value="{{ Auth::User()->phone }}" placeholder="Please enter phone number..." readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="email" name="email" value="{{ Auth::User()->email }}" placeholder="Please enter your email...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Profile Image </label>
                                                <input type="file"  name="avatar_original" class="form-control"  >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group submit">
                                    <button class="ps-btn">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
