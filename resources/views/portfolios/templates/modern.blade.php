<style>
    .m-wrap { min-height: 100vh; padding: 48px 20px; background: #0b1120; color: #e2e8f0; font-family: "Segoe UI", system-ui, -apple-system, Arial, sans-serif; }
    .m-page { max-width: 940px; margin: 0 auto; display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .m-card { padding: 28px; border-radius: 14px; background: #111a2e; border: 1px solid #1e293b; }
    .m-hero { grid-column: span 2; display: flex; align-items: center; gap: 30px; padding: 36px; background: radial-gradient(circle at top right, rgba(59,130,246,.22), transparent 55%), #111a2e; }
    .m-photo { flex: 0 0 120px; width: 120px; height: 120px; border-radius: 16px; object-fit: cover; border: 1px solid #334155; }
    .m-initial { display: flex; align-items: center; justify-content: center; background: #1d4ed8; color: #fff; font-size: 3.2rem; font-weight: 700; }
    .m-code { margin: 0 0 8px; font-family: Consolas, "Courier New", monospace; font-size: .85rem; color: #64748b; }
    .m-hero h1 { margin: 0; font-size: clamp(2rem, 5vw, 3rem); line-height: 1.1; font-weight: 700; letter-spacing: -.02em; color: #f8fafc; word-break: break-word; }
    .m-tag { display: inline-block; margin-top: 14px; padding: 3px 12px; border: 1px solid #334155; border-radius: 999px; font-family: Consolas, "Courier New", monospace; font-size: .75rem; color: #93c5fd; }
    .m-full { grid-column: span 2; }
    .m-card h2 { margin: 0 0 20px; font-family: Consolas, "Courier New", monospace; font-size: .9rem; font-weight: 400; color: #60a5fa; }
    .m-list { margin: 0; padding: 0; list-style: none; }
    .m-list li { margin-bottom: 14px; word-break: break-word; font-size: .96rem; }
    .m-list small { display: block; margin-bottom: 2px; font-family: Consolas, "Courier New", monospace; font-size: .72rem; color: #64748b; }
    .m-wrap a { color: #93c5fd; text-decoration: none; }
    .m-wrap a:hover { text-decoration: underline; }
    .m-edu { margin-bottom: 16px; padding-left: 16px; border-left: 2px solid #3b82f6; }
    .m-edu strong { display: block; color: #f8fafc; font-size: 1.05rem; }
    .m-edu span { display: block; margin-top: 2px; color: #94a3b8; font-size: .9rem; }
    .m-chips { display: flex; flex-wrap: wrap; gap: 10px; margin: 0; padding: 0; list-style: none; }
    .m-chips li { padding: 6px 14px; border: 1px solid #334155; border-radius: 6px; background: #0f172a; font-family: Consolas, "Courier New", monospace; font-size: .85rem; color: #bfdbfe; }
    .m-empty { margin: 0; color: #64748b; font-size: .9rem; font-style: italic; }
    @media (max-width: 760px) {
        .m-page { grid-template-columns: 1fr; }
        .m-hero, .m-full { grid-column: span 1; }
        .m-hero { flex-direction: column; align-items: flex-start; padding: 26px; }
    }
</style>

<div class="m-wrap">
    <div class="m-page">
        <header class="m-card m-hero">
            @if ($pic)
                <img class="m-photo" src="{{ $pic }}" alt="Profile picture of {{ $portfolio->full_name }}">
            @else
                <div class="m-photo m-initial">{{ $initial }}</div>
            @endif
            <div>
                <p class="m-code">// portfolio</p>
                <h1>{{ $displayName }}</h1>
                <span class="m-tag">IT Portfolio</span>
            </div>
        </header>

        <section class="m-card">
            <h2>// contact</h2>
            <ul class="m-list">
                <li><small>email</small><a href="mailto:{{ $portfolio->email }}">{{ $portfolio->email }}</a></li>
                @if ($portfolio->contact_number)
                    <li><small>phone</small>{{ $portfolio->contact_number }}</li>
                @endif
                @if ($portfolio->facebook_link)
                    <li><small>facebook</small>
                        @if ($fbOk)
                            <a href="{{ $portfolio->facebook_link }}" target="_blank" rel="noopener">{{ $portfolio->facebook_link }}</a>
                        @else
                            {{ $portfolio->facebook_link }}
                        @endif
                    </li>
                @endif
                @if ($portfolio->age)
                    <li><small>age</small>{{ $portfolio->age }}</li>
                @endif
            </ul>
        </section>

        <section class="m-card">
            <h2>// education</h2>
            @foreach ($portfolio->educations as $edu)
                <div class="m-edu">
                    <strong>{{ $edu->school }}</strong>
                    @if ($edu->degree)<span>{{ $edu->degree }}</span>@endif
                    @if ($edu->start_year || $edu->end_year)<span>{{ $edu->start_year }} – {{ $edu->end_year }}</span>@endif
                </div>
            @endforeach
            @if (count($portfolio->educations) === 0)
                <p class="m-empty">No education added yet.</p>
            @endif
        </section>

        <section class="m-card m-full">
            <h2>// skills</h2>
            <ul class="m-chips">
                @foreach ($portfolio->skills as $skill)
                    <li>{{ $skill->name }}</li>
                @endforeach
            </ul>
            @if (count($portfolio->skills) === 0)
                <p class="m-empty">No skills added yet.</p>
            @endif
        </section>
    </div>
</div>