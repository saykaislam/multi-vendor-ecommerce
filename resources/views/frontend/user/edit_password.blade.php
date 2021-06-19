@extends('frontend.layouts.master')
@section('title', 'User Edit Password')
@section('content')
    <main class="ps-page--my-account">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Edit Password</li>
                </ul>
                {{--                <div class="text-right">Logout</div>--}}
            </div>
        </div>
        <section class="ps-section--account">
            <div class="container">
                <div class="row">
                    @include('frontend.user.includes.user_sidebar')
                    <div class="col-lg-9" >
                        <div class="ps-section__right">
                            <form class="ps-form--account-setting" action="{{route('user.password-update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="ps-form__header" style="margin-bottom: 46px; text-align: center;">
                                    <h3> Edit Password</h3>
                                </div>
                                <div class="ps-form__content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input class="form-control" type="password" name="old_password" placeholder="Please enter Old Password...">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input class="form-control" type="password" name="password" placeholder="Please enter New Password...">
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
