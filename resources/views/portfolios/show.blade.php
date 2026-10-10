@extends('layouts.app')

@section('title', $portfolio->full_name)

@section('content')
<div class="container page-section">
    <div class="card form-card">
        <div class="portfolio-top">
            @if($portfolio->profile_picture)
                <img src="{{ asset('storage/' . $portfolio->profile_picture) }}" alt="" class="avatar-img">
            @else
                <div class="avatar">{{ strtoupper(substr($portfolio->full_name, 0, 1)) }}</div>
            @endif
            <div>
                <h2 style="margin:0">{{ $portfolio->full_name }}</h2>
                <span class="tag">{{ ucfirst($portfolio->template) }} template</span>
            </div>
        </div>

        @if($portfolio->about_me)<p class="lead">{{ $portfolio->about_me }}</p>@endif

        <p>
            {{ $portfolio->email }}
            @if($portfolio->contact_number) · {{ $portfolio->contact_number }} @endif
            @if($portfolio->address) · {{ $portfolio->address }} @endif
        </p>

        <div class="tags">
            @foreach(['facebook_link' => 'Facebook', 'instagram_link' => 'Instagram', 'linkedin_link' => 'LinkedIn', 'github_link' => 'GitHub', 'website_link' => 'Website'] as $field => $label)
                @if($portfolio->$field)
                    <a href="{{ $portfolio->$field }}" target="_blank" rel="noopener" class="tag">{{ $label }}</a>
                @endif
            @endforeach
        </div>

        <p style="margin-top:2rem">
            <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-sm btn-outline">Edit</a>
            <a href="{{ route('portfolios.index') }}" class="btn btn-sm btn-outline">Back</a>
        </p>
    </div>
</div>
@endsection