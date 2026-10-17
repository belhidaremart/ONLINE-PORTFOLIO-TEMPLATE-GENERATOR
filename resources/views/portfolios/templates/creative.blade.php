<style>
    .c-wrap { min-height: 100vh; padding-bottom: 48px; background: #f1f5f9; color: #1e293b; font-family: "Segoe UI", system-ui, -apple-system, Arial, sans-serif; }
    .c-banner { height: 190px; background: linear-gradient(120deg, #1d4ed8 0%, #4f46e5 55%, #7c3aed 100%); }
    .c-page { max-width: 900px; margin: 0 auto; padding: 0 20px; }
    .c-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 16px rgba(15,23,42,.06); }
    .c-top { display: flex; align-items: flex-start; gap: 26px; margin-top: -70px; padding: 26px 30px 28px; }
    .c-photo { flex: 0 0 132px; width: 132px; height: 132px; margin-top: -66px; border-radius: 50%; object-fit: cover; border: 5px solid #fff; box-shadow: 0 6px 18px rgba(15,23,42,.18); }
    .c-initial { display: flex; align-items: center; justify-content: center; background: #4f46e5; color: #fff; font-size: 3.4rem; font-weight: 700; }
    .c-top h1 { margin: 6px 0 0; font-size: 2.2rem; line-height: 1.1; font-weight: 700; letter-spacing: -.01em; color: #0f172a; word-break: break-word; }
    .c-top p { margin: 6px 0 14px; color: #64748b; }
    .c-chips { display: flex; flex-wrap: wrap; gap: 8px; margin: 0; padding: 0; list-style: none; }
    .c-chips li { padding: 6px 14px; border-radius: 999px; background: #eef2ff; color: #3730a3; font-size: .88rem; font-weight: 600; word-break: break-word; }
    .c-chips a { color: inherit; text-decoration: none; }
    .c-cols { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 20px; }
    .c-sec { padding: 26px 28px; }
    .c-sec h2 { display: flex; align-items: center; gap: 10px; margin: 0 0 18px; font-size: 1.05rem; font-weight: 700; color: #0f172a; }
    .c-sec h2::before { content: ""; width: 5px; height: 20px; border-radius: 3px; background: linear-gradient(#1d4ed8, #7c3aed); }
    .c-edu { margin-bottom: 18px; }
    .c-edu:last-child { margin-bottom: 0; }
    .c-edu strong { display: block; font-size: 1.05rem; color: #0f172a; }
    .c-edu span { display: block; margin-top: 2px; color: #64748b; font-size: .92rem; }
    .c-tags { display: flex; flex-wrap: wrap; gap: 10px; margin: 0; padding: 0; list-style: none; }
    .c-tags li { padding: 7px 15px; border-radius: 8px; background: #0f172a; color: #fff; font-size: .88rem; font-weight: 600; }
    .c-empty { margin: 0; color: #94a3b8; font-size: .9rem; font-style: italic; }
    @media (max-width: 760px) {
        .c-banner { height: 140px; }
        .c-top { flex-direction: column; align-items: center; margin-top: -50px; text-align: center; padding: 20px; }
        .c-photo { margin-top: -66px; }
        .c-chips { justify-content: center; }
        .c-cols { grid-template-columns: 1fr; }
    }
</style>

<div class="c-wrap">
    <div class="c-banner"></div>
    <div class="c-page">
        <header class="c-card c-top">
            @if ($pic)
                <img class="c-photo" src="{{ $pic }}" alt="Profile picture of {{ $portfolio->full_name }}">
            @else
                <div class="c-photo c-initial">{{ $initial }}</div>
            @endif
            <div>
                <h1>{{ $displayName }}</h1>
                <p>Portfolio</p>
                <ul class="c-chips">
                    <li><a href="mailto:{{ $portfolio->email }}">{{ $portfolio->email }}</a></li>
                    @if ($portfolio->contact_number)
                        <li>{{ $portfolio->contact_number }}</li>
                    @endif
                    @if ($portfolio->facebook_link)
                        <li>
                            @if ($fbOk)
                                <a href="{{ $portfolio->facebook_link }}" target="_blank" rel="noopener">Facebook</a>
                            @else
                                {{ $portfolio->facebook_link }}
                            @endif
                        </li>
                    @endif
                    @if ($portfolio->age)
                        <li>Age {{ $portfolio->age }}</li>
                    @endif
                </ul>
            </div>
        </header>

        <div class="c-cols">
            <section class="c-card c-sec">
                <h2>Education</h2>
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

            <section class="c-card c-sec">
                <h2>Skills</h2>
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
</div>