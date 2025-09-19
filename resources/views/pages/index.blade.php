@extends('layouts.master')

{{-- Remove these hardcoded sections --}}
{{-- @section('title', 'Home') --}}
{{-- @section('page-title', 'Home') --}}

@section('content')
    @include('partials.caraouselsection')
    @include('partials.factsection')
    @include('partials.aboutsection')
    @include('partials.clientsection')
    @include('partials.servicessection')
    @include('partials.teamsection')
    @include('partials.contactsection')
@endsection
