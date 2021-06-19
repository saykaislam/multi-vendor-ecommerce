@extends('frontend.layouts.master')
@section('title','Phone Verification')
@push('css')
    <link href="{{asset('frontend/css/user_auth_login.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="container">
        <form class="ps-form--account ps-tab-root" action="{{route('get-verification-code.store')}}" method="POST">
            @csrf
            <input type="hidden" name="phone" value="{{$verCode->phone}}">
            <ul class="ps-tab-list">
                <li class="active"><a href="#sign-in">Phone Verification</a></li>
            </ul>
            <div class="ps-tabs">
                <div class="ps-tab active" id="sign-in">
                    <div class="ps-form__content">
                        <h5>Enter your code</h5>
                        <div class="form-group">
                            <input  type="number" placeholder="code" id="code" class="form-control input100 @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code" autofocus>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                        <div class="form-group submit">
                            <button class="ps-btn ps-btn--fullwidth">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {!! Toastr::message() !!}
@stop
@push('js')
    <script !src = "">
        @if($errors->any())
        @foreach($errors->all() as $error )
        toastr.error('{{$error}}','Error',{
            closeButton:true,
            progressBar:true
        });
        @endforeach
        @endif
        $(document).ready(function(){
            // $(".owl").owlCarousel();
        });

        $('#code').blur(function(){
            var code = $(this).val();
            //alert(parent_id);

            $.ajax({
                url : "{{ URL('check-verification-code') }}",
                method : 'get',
                data : {
                    code : code
                },
                success : function(data){
                    console.log(data)
                    if(data != 'found'){
                        toastr.warning('Your Entered Verification code is not valid, please enter valid code.')
                        //alert('Your referal code is not valid, please contact administrator.')
                        $('#code').val('');
                    }
                },
                error : function(err){
                    console.log(err)
                }
            })
        })
    </script>
@endpush
