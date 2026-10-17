@extends('layouts.app')

@section('title', 'Edit Portfolio')

@section('content')
<section class="page">
    <div class="container narrow">
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
