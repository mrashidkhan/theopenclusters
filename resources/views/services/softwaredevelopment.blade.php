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
                <h5 class="text-primary">Software Development Services</h5>
                <h1 class="mb-4">Open Clusters Systems Software Development Services</h1>
                <p>Custom software development is the process of designing, building, integrating, scaling, and upgrading software solutions to address the pressing needs or achieve objectives of your specific business.
                We at Open Clusters Systems provide you the solutions best suited to your requirements.</p>
                <p class="mb-4">Open Clusters Systems is a leading provider of cutting-edge software development services, delivering tailored solutions that drive innovation and efficiency for businesses across various industries. With a team of experienced developers and technology experts, we specialize in creating scalable, secure, and high-performance software applications that meet the unique needs of our clients. Whether it's custom software development, application modernization, or seamless integration with existing systems, Open Clusters Systems is committed to turning your vision into reality, empowering your business with technology that accelerates growth and success.</p>
                <a href="{{ route('services') }}" class="btn btn-secondary rounded-pill px-5 py-3 text-white">Other Services</a>
            </div>
        </div>
    </div>
</div>


@endsection
