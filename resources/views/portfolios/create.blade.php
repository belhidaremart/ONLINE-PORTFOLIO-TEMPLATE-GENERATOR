@extends('layouts.app')

@section('title', 'Create Portfolio')

@section('content')
<section class="page">
    <div class="container narrow">
        <h1 class="page-title">Create My Portfolio</h1>
        <p class="page-sub">Fill in your information. Fields marked * are required.</p>

        <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('portfolios._form')
            <div class="form-actions">
                <a href="{{ route('home') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save and Choose Template</button>
            </div>
        </form>
    </div>
</section>
@endsection