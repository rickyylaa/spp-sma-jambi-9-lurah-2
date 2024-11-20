@extends('utama.layouts.app')
@section('title', 'SPP Online')

@section('content')
    <div class="slider-area section">
        <div id="hero-slider" class="slides">
            <img src="{{ asset('dist/images/banner/1.webp') }}" alt="Image" title="#slider-caption1">
        </div>
        <div id="slider-caption1" class="nivo-html-caption nivo-caption">
            <div class="container">
                <div class="row">
                    <div class="hero-content col-md-12">
                        <h2 class="wow fadeInUp" data-wow-delay="0.5s">Welcome to Study</h2>
                        <h1 class="wow fadeInUp" data-wow-delay="1s">The Best Learning Institution</h1>
                        <p class="wow fadeInUp" data-wow-delay="1.5s"> There are many variations of passages of Lorem Ipsum available, but the majority have<br class="d-none d-md-block"> suffered alteration in some form, by injected humour, or randomised words which<br class="d-none d-md-block"> don't look even slightly believable.</p>
                        <a class="btn wow fadeInUp" data-wow-delay="2s" href="courses.html">View Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
