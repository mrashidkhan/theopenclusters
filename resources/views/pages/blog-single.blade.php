@extends('layouts.master')

@section('title', $blog['title'])

@section('page-title', $blog['title'])

@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-5">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white mb-4 animated slideInDown">{{ $blog['title'] }}</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blogs</a></li>
                <li class="breadcrumb-item text-white" aria-current="page">{{ $blog['category'] }}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Blog Details Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Blog Post -->
                <div class="blog-item bg-light rounded">
                    <img src="{{ asset('img/' . $blog['image']) }}" class="img-fluid w-100 rounded-top" alt="{{ $blog['title'] }}">

                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="px-4 py-2 bg-primary text-white rounded">{{ $blog['category'] }}</span>
                            <small class="text-muted">{{ $blog['date'] }}</small>
                        </div>

                        <h2 class="mb-3">{{ $blog['title'] }}</h2>

                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('img/admin.jpg') }}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;" alt="">
                            <div>
                                <h6 class="mb-1">{{ $blog['author'] }}</h6>
                                <small class="text-muted">Author</small>
                            </div>
                        </div>

                        <p class="mb-4">{{ $blog['excerpt'] }}</p>

                        <div class="blog-content">
                            <p>{{ $blog['content'] }}</p>

                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p>

                            <blockquote class="blockquote text-center my-4">
                                <p class="mb-0 fs-5">"Innovation distinguishes between a leader and a follower."</p>
                                <footer class="blockquote-footer mt-2">Steve Jobs</footer>
                            </blockquote>

                            <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
                        </div>

                        <!-- Social Share -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                            <div class="d-flex">
                                <span class="me-3"><i class="fas fa-share me-2 text-primary"></i>{{ $blog['shares'] }} Shares</span>
                                <span><i class="fa fa-comments me-2 text-primary"></i>{{ $blog['comments'] }} Comments</span>
                            </div>
                            <div>
                                <a href="" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-facebook-f"></i></a>
                                <a href="" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-twitter"></i></a>
                                <a href="" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-linkedin-in"></i></a>
                                <a href="" class="btn btn-outline-primary btn-sm"><i class="fas fa-link"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-light rounded p-4 mt-4">
                    <h4 class="mb-4">Comments ({{ $blog['comments'] }})</h4>

                    <!-- Single Comment -->
                    <div class="d-flex mb-4">
                        <img src="{{ asset('img/admin.jpg') }}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;" alt="">
                        <div>
                            <h6>John Doe</h6>
                            <small class="text-muted mb-2 d-block">2 days ago</small>
                            <p>Great article! Very informative and well-written. Looking forward to more content like this.</p>
                        </div>
                    </div>

                    <!-- Add Comment Form -->
                    <div class="mt-4">
                        <h5>Leave a Comment</h5>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Your Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="email" class="form-control" placeholder="Your Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="Your Comment" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Recent Posts -->
                <div class="bg-light rounded p-4 mb-4">
                    <h4 class="mb-4">Recent Posts</h4>
                    @foreach($relatedBlogs as $relatedBlog)
                    <div class="d-flex mb-3">
                        <img src="{{ asset('img/' . $relatedBlog['image']) }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="">
                        <div class="ms-3">
                            <a href="{{ route('blog.show', $relatedBlog['slug']) }}" class="h6 text-decoration-none">{{ $relatedBlog['title'] }}</a>
                            <small class="text-muted d-block">{{ $relatedBlog['date'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Categories -->
                <div class="bg-light rounded p-4 mb-4">
                    <h4 class="mb-4">Categories</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none">Web Design <span class="text-muted">(12)</span></a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Development <span class="text-muted">(8)</span></a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Mobile App <span class="text-muted">(15)</span></a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Cloud Technology <span class="text-muted">(6)</span></a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Security <span class="text-muted">(9)</span></a></li>
                    </ul>
                </div>

                <!-- Tags -->
                <div class="bg-light rounded p-4">
                    <h4 class="mb-4">Tags</h4>
                    <div>
                        <a href="#" class="btn btn-outline-primary btn-sm me-2 mb-2">Web Design</a>
                        <a href="#" class="btn btn-outline-primary btn-sm me-2 mb-2">Laravel</a>
                        <a href="#" class="btn btn-outline-primary btn-sm me-2 mb-2">Mobile App</a>
                        <a href="#" class="btn btn-outline-primary btn-sm me-2 mb-2">Cloud</a>
                        <a href="#" class="btn btn-outline-primary btn-sm me-2 mb-2">Security</a>
                        <a href="#" class="btn btn-outline-primary btn-sm me-2 mb-2">AI</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Details End -->

@endsection
