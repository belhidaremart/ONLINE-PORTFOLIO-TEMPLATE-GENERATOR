<style>
    .s-wrap { min-height: 100vh; padding: 48px 20px; background: #eef1f5; color: #1e293b; font-family: "Segoe UI", system-ui, -apple-system, Arial, sans-serif; }
    .s-page { max-width: 880px; margin: 0 auto; background: #fff; border-radius: 6px; box-shadow: 0 2px 4px rgba(15,23,42,.06), 0 14px 40px rgba(15,23,42,.08); overflow: hidden; }
    .s-head { display: flex; align-items: center; gap: 28px; padding: 40px 44px 32px; border-bottom: 4px solid #2563eb; }
    .s-photo { flex: 0 0 104px; width: 104px; height: 104px; border-radius: 12px; object-fit: cover; }
    .s-initial { display: flex; align-items: center; justify-content: center; background: #2563eb; color: #fff; font-size: 2.8rem; font-weight: 700; }
    .s-head h1 { margin: 0; font-size: 2.4rem; line-height: 1.1; font-weight: 700; letter-spacing: -.01em; color: #0f172a; word-break: break-word; }
    .s-head p { margin: 8px 0 0; color: #64748b; font-size: .95rem; letter-spacing: .04em; }
    .s-body { display: grid; grid-template-columns: 1fr 280px; }
    .s-main { padding: 34px 44px; }
    .s-side { padding: 34px 32px; background: #f8fafc; border-left: 1px solid #e2e8f0; }
    .s-sec { margin-bottom: 34px; }
    .s-sec:last-child { margin-bottom: 0; }
    .s-sec h2 { margin: 0 0 18px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0; font-size: .78rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: #2563eb; }
    .s-edu { position: relative; margin-bottom: 22px; padding-left: 22px; border-left: 2px solid #cbd5e1; }
    .s-edu::before { content: ""; position: absolute; left: -6px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: #2563eb; }
    .s-edu strong { display: block; font-size: 1.08rem; color: #0f172a; }
    .s-edu span { display: block; margin-top: 2px; color: #64748b; font-size: .93rem; }
    .s-list { margin: 0; padding: 0; list-style: none; font-size: .92rem; }
    .s-list li { margin-bottom: 14px; word-break: break-word; }
    .s-list small { display: block; margin-bottom: 2px; color: #94a3b8; font-size: .68rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; }
    .s-wrap a { color: #1d4ed8; text-decoration: none; }
    .s-tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 0; padding: 0; list-style: none; }
    .s-tags li { padding: 5px 11px; border: 1px solid #bfdbfe; border-radius: 4px; background: #eff6ff; color: #1d4ed8; font-size: .85rem; font-weight: 600; }
    .s-empty { margin: 0; color: #94a3b8; font-size: .9rem; font-style: italic; }
    @media (max-width: 760px) {
        .s-head { flex-direction: column; align-items: flex-start; padding: 28px 24px; }
        .s-body { grid-template-columns: 1fr; }
        .s-main { padding: 26px 24px; }
        .s-side { padding: 26px 24px; border-left: 0; border-top: 1px solid #e2e8f0; }
        .s-head h1 { font-size: 2rem; }
    }
</style>

<div class="s-wrap">
    <div class="s-page">
        <header class="s-head">
            @if ($pic)
                <img class="s-photo" src="{{ $pic }}" alt="Profile picture of {{ $portfolio->full_name }}">
            @else
                <div class="s-photo s-initial">{{ $initial }}</div>
            @endif
            <div>
                <h1>{{ $displayName }}</h1>
                <p>Portfolio</p>
            </div>
        </header>

        <div class="s-body">
            <main class="s-main">
                <section class="s-sec">
                    <h2>Education</h2>
                    @foreach ($portfolio->educations as $edu)
                        <div class="s-edu">
                            <strong>{{ $edu->school }}</strong>
                            @if ($edu->degree)<span>{{ $edu->degree }}</span>@endif
                            @if ($edu->start_year || $edu->end_year)<span>{{ $edu->start_year }} – {{ $edu->end_year }}</span>@endif
                        </div>
                    @endforeach
                    @if (count($portfolio->educations) === 0)
                        <p class="s-empty">No education added yet.</p>
                    @endif
                </section>
            </main>

            <aside class="s-side">
                <section class="s-sec">
                    <h2>Contact</h2>
                    <ul class="s-list">
                        <li><small>Email</small><a href="mailto:{{ $portfolio->email }}">{{ $portfolio->email }}</a></li>
                        @if ($portfolio->contact_number)
                            <li><small>Phone</small>{{ $portfolio->contact_number }}</li>
                        @endif
                        @if ($portfolio->facebook_link)
                            <li><small>Facebook</small>
                                @if ($fbOk)
                                    <a href="{{ $portfolio->facebook_link }}" target="_blank" rel="noopener">{{ $portfolio->facebook_link }}</a>
                                @else
                                    {{ $portfolio->facebook_link }}
                                @endif
                            </li>
                        @endif
                        @if ($portfolio->age)
                            <li><small>Age</small>{{ $portfolio->age }}</li>
                        @endif
                    </ul>
                </section>

                <section class="s-sec">
                    <h2>Skills</h2>
                    <ul class="s-tags">
                        @foreach ($portfolio->skills as $skill)
                            <li>{{ $skill->name }}</li>
                        @endforeach
                    </ul>
                    @if (count($portfolio->skills) === 0)
                        <p class="s-empty">No skills added yet.</p>
                    @endif
                </section>
            </aside>
        </div>
    </div>
</div>