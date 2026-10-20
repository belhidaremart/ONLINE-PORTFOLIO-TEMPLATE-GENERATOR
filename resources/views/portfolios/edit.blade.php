@extends('layouts.app')

@section('title', 'Edit Portfolio')

@push('styles')
<style>
    .back-btn { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 18px; padding: 9px 18px; border: 1px solid #22d3ee; border-radius: 999px; color: #22d3ee; font-weight: 600; text-decoration: none; }
    .back-btn:hover { background: #22d3ee; color: #04202a; }
    .back-btn svg { width: 18px; height: 18px; }
</style>
@endpush

@section('content')
<section class="page">
    <div class="container narrow">
        <a href="{{ route('portfolios.template', $portfolio) }}" class="back-btn" aria-label="Back to choose a template">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"></path><path d="M12 19l-7-7 7-7"></path></svg>
            Back
        </a>
        <h1 class="page-title">Edit Portfolio</h1>
        <p class="page-sub">Change your information and press Save.</p>

        <form action="{{ route('portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('portfolios._form')
            <div class="form-actions">
                <a href="{{ route('portfolios.show', $portfolio) }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</section>
@endsection