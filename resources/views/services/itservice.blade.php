@extends('layouts.master')

@section('title', 'Home')

@section('page-title', 'Home')

@section('content')

<div class="container-fluid py-5 my-5">
    <div class="container pt-5">
        <div class="row g-5">
            <div class="col-lg-5 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".3s">
                <div class="h-100 position-relative">
                    <img src="{{ asset('img/about-1.jpg') }}" class="img-fluid w-75 rounded" alt="" style="margin-bottom: 25%;">
                    <div class="position-absolute w-75" style="top: 25%; left: 25%;">
                        <img src="{{ asset('img/about-2.jpg') }}" class="img-fluid w-100 rounded" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".5s">
                <h5 class="text-primary">IT Services</h5>
                <h1 class="mb-4">Open Clusters Systems IT Services</h1>
                <p>Whether you need custom web and mobile development or a dedicated team of your own, Open Clusters Systems is ready to help. Whether you need custom web and mobile development or a dedicated team of your own, Hi-tech Solution Network is ready to help.</p>
                <p class="mb-4">Whether you need custom web and mobile development or a dedicated team of your own, Hi-tech Solution Network is ready to help.</p>
                <a href="{{ route('service') }}" class="btn btn-secondary rounded-pill px-5 py-3 text-white">Other Services</a>
            </div>
        </div>
    </div>
</div>



@endsection
