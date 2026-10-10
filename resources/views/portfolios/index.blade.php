@extends('layouts.app')

@section('title', 'Manage Portfolios')

@section('content')
<div class="container page-section">

    <div class="page-header">
        <div>
            <span class="badge">Dashboard</span>
            <h1>Manage <span class="gradient-text">Portfolios</span></h1>
            <p class="lead">View, edit, or delete your saved portfolios.</p>
        </div>
        <a href="{{ route('portfolios.create') }}" class="btn btn-primary">+ Create New</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if(count($portfolios))
        <div class="portfolio-grid">
            @foreach($portfolios as $portfolio)
                <div class="portfolio-card">
                    <div class="portfolio-top">
                        <div class="avatar">{{ strtoupper(substr($portfolio->name, 0, 1)) }}</div>
                        <h3>{{ $portfolio->name }}</h3>
                    </div>
                    <div class="portfolio-actions">
                        <a href="{{ route('portfolios.show', $portfolio) }}" class="btn btn-sm btn-outline">View</a>
                        <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST"
                              onsubmit="return confirm('Delete this portfolio?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">P</div>
            <h2>No portfolios yet</h2>
            <p>Create your first portfolio to see it here.</p>
            <a href="{{ route('portfolios.create') }}" class="btn btn-primary">Create My Portfolio</a>
        </div>
    @endif

</div>
@endsection