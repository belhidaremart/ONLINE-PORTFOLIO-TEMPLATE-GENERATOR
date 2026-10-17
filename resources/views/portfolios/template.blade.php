@extends('layouts.app')

@section('title', 'Choose a Template')

@push('styles')
<style>
    .steps { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin-bottom: 26px; font-size: .92rem; font-weight: 600; }
    .steps span.dot { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; margin-right: 8px; border-radius: 50%; border: 2px solid #4b5578; color: #9aa5cf; font-size: .8rem; }
    .steps .done .dot { border-color: #22c55e; color: #22c55e; }
    .steps .now .dot { border-color: #22d3ee; background: #22d3ee; color: #04202a; }
    .steps .line { width: 36px; height: 2px; background: #4b5578; }
    .tpl-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 28px; }
    .tpl-card { display: flex; flex-direction: column; border-radius: 18px; background: rgba(17,24,52,.85); border: 2px solid rgba(129,140,248,.3); box-shadow: 0 10px 30px rgba(0,0,0,.35); overflow: hidden; }
    .tpl-card.is-selected { border-color: #22d3ee; box-shadow: 0 0 0 3px rgba(34,211,238,.25), 0 10px 30px rgba(0,0,0,.35); }
    .tpl-thumb { position: relative; display: block; width: 100%; aspect-ratio: 3 / 2; overflow: hidden; background: #fff; border-bottom: 1px solid rgba(129,140,248,.3); }
    .tpl-thumb iframe { position: absolute; top: 0; left: 0; width: 400%; height: 400%; border: 0; transform: scale(.25); transform-origin: 0 0; pointer-events: none; }
    .tpl-body { display: flex; flex: 1; flex-direction: column; gap: 10px; padding: 20px; }
    .tpl-body h3 { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin: 0; font-size: 1.2rem; color: #fff; }
    .tpl-badge { padding: 2px 12px; border-radius: 999px; background: rgba(34,197,94,.2); border: 1px solid #22c55e; color: #86efac; font-size: .75rem; font-weight: 700; }
    .tpl-body p { flex: 1; margin: 0; color: #9aa5cf; font-size: .93rem; line-height: 1.5; }
    .tpl-actions { display: flex; flex-direction: column; align-items: flex-start; gap: 10px; }
    .tpl-actions form { margin: 0; }
    @media (max-width: 992px) { .tpl-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<section class="page">
    <div class="container">
        <div class="steps">
            <div class="done"><span class="dot">&#10003;</span>Information</div>
            <span class="line"></span>
            <div class="now"><span class="dot">2</span>Template</div>
            <span class="line"></span>
            <div><span class="dot">3</span>Preview</div>
        </div>

        <h1 class="page-title">Choose a Template</h1>
        <p class="page-sub">These are live previews built from the information you saved. Pick the one that fits you; you can change it later.</p>

        @error('template')<div class="alert alert-danger">{{ $message }}</div>@enderror

        <a href="{{ route('portfolios.edit', $portfolio) }}" class="btn btn-sm btn-outline">Edit information</a>

        @php
            $options = [
                'simple'   => ['Simple', 'Classic executive résumé in navy and gold. Print-friendly.'],
                'modern'   => ['Modern', 'Frosted-glass cards on a soft gradient, with rounded corners.'],
                'creative' => ['Creative', 'Cyber-tech look with neon green and corner brackets, made for IT students.'],
            ];
            $number = 0;
        @endphp

        <div class="tpl-grid">
            @foreach ($options as $key => $info)
                @php $number++; $isSelected = $portfolio->template === $key; @endphp
                <div class="tpl-card {{ $isSelected ? 'is-selected' : '' }}">
                    <a class="tpl-thumb" href="{{ route('portfolios.show', ['portfolio' => $portfolio, 'template' => $key]) }}" aria-label="Preview the {{ $info[0] }} template">
                        <iframe src="{{ route('portfolios.show', ['portfolio' => $portfolio, 'template' => $key, 'embed' => 1]) }}" title="{{ $info[0] }} template preview" loading="lazy" tabindex="-1"></iframe>
                    </a>
                    <div class="tpl-body">
                        <h3>{{ $number }}. {{ $info[0] }} @if ($isSelected)<span class="tpl-badge">&#10003; Selected</span>@endif</h3>
                        <p>{{ $info[1] }}</p>
                        <div class="tpl-actions">
                            <a href="{{ route('portfolios.show', ['portfolio' => $portfolio, 'template' => $key]) }}" class="btn btn-sm btn-outline">Preview</a>
                            <form action="{{ route('portfolios.template.update', $portfolio) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="template" value="{{ $key }}">
                                <button type="submit" class="btn btn-sm btn-primary">{{ $isSelected ? 'Keep this template' : 'Use this template' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-actions" style="margin-top:32px">
            <a href="{{ route('portfolios.index') }}" class="btn btn-outline">Back to Manage</a>
        </div>
    </div>
</section>
@endsection
