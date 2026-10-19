@extends('layouts.app')

@section('title', 'Manage Portfolios')

@section('content')
<section class="page">
    <div class="container">
        <div class="page-head">
            <div>
                <h1 class="page-title">Manage Portfolios</h1>
                <p class="page-sub">View, edit, or delete your saved portfolios.</p>
            </div>
            
        </div>

        @if ($portfolios->count())
            <div class="portfolio-grid">
                @foreach ($portfolios as $portfolio)
                    <div class="portfolio-card">
                        <div class="portfolio-top">
                            @if ($portfolio->profile_picture)
                                <img class="avatar" src="{{ asset('storage/' . $portfolio->profile_picture) }}" alt="{{ $portfolio->full_name }}">
                            @else
                                <div class="avatar avatar-empty">{{ strtoupper(substr($portfolio->full_name ?? '?', 0, 1)) }}</div>
                            @endif
                            <div class="portfolio-info">
                                <h3>{{ $portfolio->full_name }}</h3>
                                <p>{{ $portfolio->email }}</p>
                            </div>
                        </div>

                        <span class="badge">Template: {{ ucfirst($portfolio->template ?? 'simple') }}</span>

                        <div class="card-actions">
                            <a href="{{ route('portfolios.show', $portfolio->id) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('portfolios.edit', $portfolio->id) }}" class="btn btn-sm btn-outline">Edit</a>

                            <details class="confirm-delete">
                                <summary class="btn btn-sm btn-danger">Delete</summary>
                                <form action="{{ route('portfolios.destroy', $portfolio->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <p>Delete this portfolio? This cannot be undone.</p>
                                    <button type="submit" class="btn btn-sm btn-danger">Yes, delete</button>
                                </form>
                            </details>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrap">{{ $portfolios->links() }}</div>
        @else
            <div class="empty-state">
                <h3>No portfolios yet</h3>
                <p>Create your first portfolio to see it here.</p>
                <a href="{{ route('portfolios.create') }}" class="btn btn-primary">Create My Portfolio</a>
            </div>
        @endif
    </div>
</section>
@endsection