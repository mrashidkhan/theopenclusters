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
                <h5 class="text-primary">IT & Telecom Staffing and Placements</h5>
                <h1 class="mb-4">Open Clusters Systems IT & Telecom Staffing and Placements</h1>
                <p>Finding and hiring 10X talent takes valuable time and resources. When you work with Open Clusters Systems, you get a dedicated team of expert web and mobile app developers who are ready to get to work for you.</p>
                <p class="mb-4">It saves you the time and effort of having to go through a recruitment process. You get to bring in immediate development talents and skills to your existing team without any long-term commitments or potential HR issues. Less risk, more immediate productivity.</p>
                <a href="{{ route('services') }}" class="btn btn-secondary rounded-pill px-5 py-3 text-white">Other Services</a>
            </div>
        </div>
    </div>
</div>


@endsection
