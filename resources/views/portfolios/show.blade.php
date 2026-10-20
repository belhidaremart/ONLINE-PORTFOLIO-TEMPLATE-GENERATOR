@php
    $displayName = $embed ? 'Portfolio Template' : $portfolio->full_name;
    $initial = mb_strtoupper(mb_substr($displayName, 0, 1));
    $pic = $portfolio->profile_picture ? asset('storage/' . $portfolio->profile_picture) : null;
    $fbOk = $portfolio->facebook_link && str_starts_with($portfolio->facebook_link, 'http');
    $names = ['simple' => 'Simple', 'modern' => 'Modern', 'creative' => 'Creative'];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $portfolio->full_name }} - Portfolio</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; }
        .tb { padding: 14px 20px; background: #070b1a; border-bottom: 1px solid rgba(34,211,238,.35); font-family: "Segoe UI", system-ui, Arial, sans-serif; color: #e5e9ff; }
        .tb-inner { max-width: 1000px; margin: 0 auto; display: flex; flex-direction: column; gap: 12px; }
        .tb-row { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        .tb-label { margin-right: 4px; font-size: .8rem; letter-spacing: .1em; text-transform: uppercase; color: #8c97c9; }
        .tb a, .tb button, .tb summary { display: inline-block; padding: 8px 16px; border: 1px solid rgba(129,140,248,.55); border-radius: 999px; background: transparent; color: #e5e9ff; font: inherit; font-size: .9rem; font-weight: 600; text-decoration: none; cursor: pointer; list-style: none; }
        .tb summary::-webkit-details-marker { display: none; }
        .tb a:hover, .tb button:hover, .tb summary:hover { background: rgba(129,140,248,.2); }
        .tb .on { background: #22d3ee; border-color: #22d3ee; color: #04202a; }
        .tb .go { background: linear-gradient(135deg, #06b6d4, #8b5cf6); border-color: transparent; color: #fff; }
        .tb .bad { border-color: #f87171; color: #fecaca; }
        .tb .bad-fill { background: #dc2626; border-color: #dc2626; color: #fff; }
        .tb details { position: relative; }
        .tb .confirm { position: absolute; z-index: 10; top: 110%; left: 0; width: 250px; padding: 14px; border-radius: 14px; background: #121936; border: 1px solid #f87171; }
        .tb .confirm p { margin: 0 0 10px; font-size: .9rem; }
        .tb .confirm form { display: inline; }
        .tb .flash { margin: 0; padding: 8px 14px; border-radius: 10px; background: rgba(34,197,94,.18); border: 1px solid #22c55e; font-size: .9rem; }
        .tb .tip { margin: 0; font-size: .78rem; color: #8c97c9; }
        .tb a.back { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-color: #22d3ee; color: #22d3ee; }
        .tb a.back:hover { background: #22d3ee; color: #04202a; }
        .tb a.back svg { width: 18px; height: 18px; }
    </style>
</head>
<body>

@if (!$embed)
    <nav class="tb">
        <div class="tb-inner">
            <div class="tb-row">
                <a href="{{ route('portfolios.template', $portfolio) }}" class="back" aria-label="Back to choose a template">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"></path><path d="M12 19l-7-7 7-7"></path></svg>
                    Back
                </a>
            </div>

            @if (session('success'))
                <p class="flash">{{ session('success') }}</p>
            @endif

            @if (request()->has('template'))
                <div class="tb-row">
                    <span class="tb-label">Template</span>
                    @foreach ($names as $key => $label)
                        <a href="{{ route('portfolios.show', ['portfolio' => $portfolio, 'template' => $key]) }}" class="{{ $template === $key ? 'on' : '' }}">{{ $label }}</a>
                    @endforeach
                </div>
            @endif

            <div class="tb-row">
                @if ($template !== $saved)
                    <form action="{{ route('portfolios.template.update', $portfolio) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="template" value="{{ $template }}">
                        <button type="submit" class="go">Use the {{ $names[$template] }} template</button>
                    </form>
                @endif
                <a href="{{ route('portfolios.edit', $portfolio) }}">Edit</a>
                <a href="{{ route('portfolios.index') }}">Manage</a>
                <details>
                    <summary class="bad">Delete</summary>
                    <div class="confirm">
                        <p>Delete this portfolio? This cannot be undone.</p>
                        <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bad-fill">Yes, delete</button>
                        </form>
                    </div>
                </details>
            </div>

            <p class="tip">Want a PDF? Press Ctrl + P in your browser and choose "Save as PDF".</p>
        </div>
    </nav>
@endif

@include('portfolios.templates.' . $template)

</body>
</html>