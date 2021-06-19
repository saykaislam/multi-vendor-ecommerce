<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function About() {
        return view('frontend.pages.about_us');
    }
    public function contact() {
        return view('frontend.pages.contact');
    }
    public function faqs() {
        return view('frontend.pages.faq');
    }
    public function policy() {
        return view('frontend.pages.policy');
    }
    public function terms() {
        return view('frontend.pages.terms_conditions');
    }
    public function shipping() {
        return view('frontend.pages.shipping');
    }
    public function returns() {
        return view('frontend.pages.return');
    }
}
