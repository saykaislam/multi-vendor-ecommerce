@extends('frontend.layouts.master')
@section('title', 'Contact')
@section('content')
    <div class="ps-page--single" id="contact-us">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Contact Us</li>
                </ul>

            </div>
        </div>
{{--        <div id="contact-map" data-address="17 Queen St, Southbank, Melbourne 10560, Australia" data-title="Funiture!" data-zoom="17"></div>--}}
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14604.557245622878!2d90.360452!3d23.778053!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x14c0ec04f1828c03!2saccounting%20software%20in%20bangladesh%20-%20Staritltd!5e0!3m2!1sen!2sbd!4v1610961117516!5m2!1sen!2sbd" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        <div class="ps-contact-info">
            <div class="container">
                <div class="ps-section__header">
                    <h3>Contact Us For Any Questions</h3>
                </div>
                <div class="ps-section__content">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                                <h4>Contact Directly</h4>
                                <p><a href="#"><span class="__cf_email__" data-cfemail="b6d5d9d8c2d7d5c2f6dbd7c4c2d0c3c4cf98d5d9db">[email&#160;protected]</span></a><span>(+004) 912-3548-07</span></p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                                <h4>Head Quater</h4>
                                <p><span>17 Queen St, Southbank, Melbourne 10560, Australia</span></p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                                <h4>Work With Us</h4>
                                <p><span>Send your CV to our email:</span><a href="#"><span class="__cf_email__" data-cfemail="cba8aab9aeaeb98ba6aab9bfadbeb9b2e5a8a4a6">[email&#160;protected]</span></a></p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                                <h4>Customer Service</h4>
                                <p><a href="#"><span class="__cf_email__" data-cfemail="60031513140f0d051203011205200d011214061512194e030f0d">[email&#160;protected]</span></a><span>(800) 843-2446</span></p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                                <h4>Media Relations</h4>
                                <p><a href="#"><span class="__cf_email__" data-cfemail="157870717c7455787467617360676c3b767a78">[email&#160;protected]</span></a><span>(801) 947-3564</span></p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                                <h4>Vendor Support</h4>
                                <p><a href="#"><span class="__cf_email__" data-cfemail="2254474c464d50515752524d5056624f4350564457505b0c414d4f">[email&#160;protected]</span></a><span>(801) 947-3100</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ps-contact-form">
            <div class="container">
                <form class="ps-form--contact-us" action="http://nouthemes.net/html/martfury/index.html" method="get">
                    <h3>Get In Touch</h3>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Name *">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Email *">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Subject *">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group submit">
                        <button class="ps-btn">Send message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('frontend/plugins/gmap3.min.js')}}"></script>
@endpush
