<style>
    .c-wrap { min-height: 100vh; padding: 40px 20px; background-color: #eef4f0; background-image: linear-gradient(rgba(22,163,74,.08) 1px, transparent 1px), linear-gradient(90deg, rgba(22,163,74,.08) 1px, transparent 1px); background-size: 28px 28px; color: #052e16; font-family: "Courier New", Consolas, monospace; }
    .c-page { max-width: 980px; margin: 0 auto; display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .c-box { position: relative; padding: 28px; background: rgba(255,255,255,.88); border: 1px solid rgba(22,163,74,.35); }
    .c-box::before, .c-box::after { content: ""; position: absolute; width: 14px; height: 14px; border: 2px solid #16a34a; }
    .c-box::before { top: -2px; left: -2px; border-right: 0; border-bottom: 0; }
    .c-box::after { right: -2px; bottom: -2px; border-left: 0; border-top: 0; }
    .c-hero { grid-column: span 2; display: grid; grid-template-columns: 1fr 190px; gap: 30px; align-items: center; padding: 36px; }
    .c-boot { margin: 0 0 14px; font-size: .85rem; color: #166534; }
    .c-boot b { color: #16a34a; animation: c-blink 1.6s steps(2, start) infinite; }
    .c-hero h1 { margin: 0; font-size: clamp(2.4rem, 8vw, 4.6rem); line-height: 1; font-weight: 900; text-transform: uppercase; letter-spacing: .04em; color: #15803d; word-break: break-word; }
    .c-tag { display: inline-block; margin-top: 16px; padding: 4px 14px; border: 1px solid #16a34a; background: #dcfce7; font-size: .8rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; }
    .c-photo { display: block; width: 190px; height: 190px; object-fit: cover; border: 2px solid #16a34a; padding: 6px; background: #fff; }
    .c-initial { display: flex; align-items: center; justify-content: center; font-size: 5rem; font-weight: 900; color: #15803d; }
    .c-box h2 { display: flex; align-items: center; gap: 12px; margin: 0 0 18px; font-size: 1rem; letter-spacing: .14em; text-transform: uppercase; }
    .c-box h2 em { color: #16a34a; font-style: normal; }
    .c-box h2::after { content: ""; flex: 1; height: 1px; background: linear-gradient(90deg, rgba(22,163,74,.6), transparent); }
    .c-full { grid-column: span 2; }
    .c-list { margin: 0; padding: 0; list-style: none; font-size: .95rem; }
    .c-list li { margin-bottom: 12px; word-break: break-word; }
    .c-list small { display: block; color: #16a34a; font-size: .7rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
    .c-box a { color: #052e16; text-decoration-color: #16a34a; text-decoration-thickness: 2px; }
    .c-edu { margin-bottom: 14px; padding-left: 14px; border-left: 3px solid #16a34a; }
    .c-edu strong { display: block; }
    .c-edu span { display: block; color: #166534; font-size: .88rem; }
    .c-tags { display: flex; flex-wrap: wrap; gap: 10px; margin: 0; padding: 0; list-style: none; }
    .c-tags li { padding: 6px 14px; border: 1px solid #16a34a; background: #f0fdf4; font-size: .88rem; font-weight: 700; }
    .c-tags li::before { content: "> "; color: #16a34a; }
    .c-empty { margin: 0; color: #4d7c5f; font-style: italic; }
    @keyframes c-blink { to { visibility: hidden; } }
    @media (prefers-reduced-motion: reduce) { .c-boot b { animation: none; } }
    @media (max-width: 760px) {
        .c-page { grid-template-columns: 1fr; }
        .c-hero, .c-full { grid-column: span 1; }
        .c-hero { grid-template-columns: 1fr; text-align: center; }
        .c-photo { margin: 0 auto; }
    }
</style>

<div class="c-wrap">
    <div class="c-page">
        <header class="c-box c-hero">
            <div>
                <p class="c-boot">&gt; loading profile [ <b>OK</b> ]</p>
                <h1>{{ $displayName }}</h1>
                <span class="c-tag">Portfolio</span>
            </div>
            @if ($pic)
                <img class="c-photo" src="{{ $pic }}" alt="Profile picture of {{ $portfolio->full_name }}">
            @else
                <div class="c-photo c-initial">{{ $initial }}</div>
            @endif
        </header>

        <section class="c-box">
            <h2><em>01 /</em> Contact</h2>
            <ul class="c-list">
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

        <section class="c-box">
            <h2><em>02 /</em> Education</h2>
            @foreach ($portfolio->educations as $edu)
                <div class="c-edu">
                    <strong>{{ $edu->school }}</strong>
                    @if ($edu->degree)<span>{{ $edu->degree }}</span>@endif
                    @if ($edu->start_year || $edu->end_year)<span>{{ $edu->start_year }} – {{ $edu->end_year }}</span>@endif
                </div>
            @endforeach
            @if (count($portfolio->educations) === 0)
                <p class="c-empty">No education added yet.</p>
            @endif
        </section>

        <section class="c-box c-full">
            <h2><em>03 /</em> Skills</h2>
            <ul class="c-tags">
                @foreach ($portfolio->skills as $skill)
                    <li>{{ $skill->name }}</li>
                @endforeach
            </ul>
            @if (count($portfolio->skills) === 0)
                <p class="c-empty">No skills added yet.</p>
            @endif
        </section>
    </div>
</div>