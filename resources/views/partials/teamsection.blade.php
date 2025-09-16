<!-- Team Start -->
<div class="container-fluid py-5 mb-5 team">
    <div class="container">
        <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-primary">Our Team</h5>
            <h1>Meet our expert Team</h1>
        </div>

        @php
            $teamMembers = \App\Models\Staff::active()->orderBy('name')->get();
        @endphp

        @if($teamMembers->count() > 0)
        <div class="owl-carousel team-carousel wow fadeIn" data-wow-delay=".5s">
            @foreach($teamMembers as $member)
            <div class="rounded team-item">
                <div class="team-content">
                    <div class="team-img-icon">
                        <div class="team-img rounded-circle">
                            <img src="{{ $member->avatar_url }}" class="img-fluid w-100 rounded-circle" alt="{{ $member->name }}">
                        </div>
                        <div class="team-name text-center py-3">
                            <h4 class="">{{ $member->name }}</h4>
                            <p class="m-0">{{ $member->position ?? 'Team Member' }}</p>
                        </div>
                        <div class="team-icon d-flex justify-content-center pb-4">
                            @if($member->social_links && is_array($member->social_links))
                                @if(isset($member->social_links['facebook']) && $member->social_links['facebook'])
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="{{ $member->social_links['facebook'] }}" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                @endif

                                @if(isset($member->social_links['twitter']) && $member->social_links['twitter'])
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="{{ $member->social_links['twitter'] }}" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif

                                @if(isset($member->social_links['instagram']) && $member->social_links['instagram'])
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="{{ $member->social_links['instagram'] }}" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif

                                @if(isset($member->social_links['linkedin']) && $member->social_links['linkedin'])
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="{{ $member->social_links['linkedin'] }}" target="_blank">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                @endif
                            @else
                                <!-- Default social icons if no social links provided -->
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="#"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Fallback if no team members in database -->
        <div class="text-center">
            <p class="text-muted">Our amazing team information will be available soon.</p>
        </div>
        @endif
    </div>
</div>
<!-- Team End -->
