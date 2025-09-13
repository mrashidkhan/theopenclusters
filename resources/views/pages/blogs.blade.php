@extends('layouts.master')

@section('title', 'Blogs')

@section('page-title', 'Blogs')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-5">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4 animated slideInDown">Our Blogs</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item text-white" aria-current="page">Blogs</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

@include('partials.blogsection')

@endsection
