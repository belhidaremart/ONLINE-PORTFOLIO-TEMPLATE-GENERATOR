@extends('layouts.app')

@section('title', 'Edit Portfolio')

@section('content')
<div class="container page-section">
    <div class="page-header">
        <div>
            <span class="badge">Editing</span>
            <h1>Edit <span class="gradient-text">{{ $portfolio->full_name }}</span></h1>
        </div>
        <a href="{{ route('portfolios.index') }}" class="btn btn-outline">← Back</a>
    </div>

    <div class="card form-card">
        <form action="{{ route('portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('portfolios._form')
            <button type="submit" class="btn btn-primary">Update Portfolio</button>
        </form>
    </div>
</div>
@endsection