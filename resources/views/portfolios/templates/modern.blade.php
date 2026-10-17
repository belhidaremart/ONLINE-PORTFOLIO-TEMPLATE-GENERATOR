<style>
    .m-wrap { min-height: 100vh; padding: 48px 20px; background: linear-gradient(135deg, #e0e7ff 0%, #fae8ff 50%, #dbeafe 100%); color: #1e1b4b; font-family: "Segoe UI", system-ui, Arial, sans-serif; }
    .m-page { max-width: 980px; margin: 0 auto; display: grid; grid-template-columns: repeat(6, 1fr); gap: 20px; }
    .m-card { padding: 28px; border-radius: 24px; background: rgba(255,255,255,.62); border: 1px solid rgba(255,255,255,.9); box-shadow: 0 10px 30px rgba(79,70,229,.12); backdrop-filter: blur(12px); }
    .m-hero { grid-column: span 6; display: flex; align-items: center; justify-content: space-between; gap: 24px; padding: 40px; }
    .m-hero small { display: inline-block; padding: 4px 14px; border-radius: 999px; background: #4f46e5; color: #fff; font-size: .75rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
    .m-hero h1 { margin: 16px 0 8px; font-size: clamp(2.2rem, 6vw, 3.6rem); line-height: 1.05; font-weight: 800; background: linear-gradient(90deg, #4f46e5, #c026d3); -webkit-background-clip: text; background-clip: text; color: transparent; word-break: break-word; }
    .m-hero p { margin: 0; color: #6366f1; }
    .m-photo { flex: 0 0 150px; width: 150px; height: 150px; border-radius: 32px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 12px 30px rgba(79,70,229,.25); }
    .m-initial { display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #6366f1, #d946ef); color: #fff; font-size: 4rem; font-weight: 800; }
    .m-contact { grid-column: span 2; }
    .m-edu { grid-column: span 4; }
    .m-skills { grid-column: span 6; }
    .m-card h2 { margin: 0 0 16px; font-size: 1rem; text-transform: uppercase; letter-spacing: .1em; color: #6366f1; }
    .m-list { margin: 0; padding: 0; list-style: none; }
    .m-list li { margin-bottom: 14px; word-break: break-word; font-size: .95rem; }
    .m-list small { display: block; color: #818cf8; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; }
    .m-wrap a { color: #4338ca; text-decoration: none; font-weight: 600; }
    .m-edu-item { margin-bottom: 14px; padding: 16px 18px; border-radius: 16px; background: rgba(255,255,255,.7); box-shadow: 0 4px 12px rgba(79,70,229,.08); }
    .m-edu-item strong { display: block; font-size: 1.05rem; }
    .m-edu-item span { display: block; color: #6b7280; font-size: .9rem; margin-top: 2px; }
    .m-chips { display: flex; flex-wrap: wrap; gap: 10px; margin: 0; padding: 0; list-style: none; }
    .m-chips li { padding: 8px 18px; border-radius: 999px; background: linear-gradient(135deg, #eef2ff, #fdf4ff); border: 1px solid #c7d2fe; font-weight: 600; font-size: .9rem; color: #4338ca; box-shadow: 0 3px 8px rgba(79,70,229,.1); }
    .m-empty { margin: 0; color: #9ca3af; font-style: italic; }
    @media (max-width: 760px) {
        .m-page { grid-template-columns: 1fr; }
        .m-hero, .m-contact, .m-edu, .m-skills { grid-column: span 1; }
        .m-hero { flex-direction: column-reverse; text-align: center; padding: 28px; }
    }
</style>

<div class="m-wrap">
    <div class="m-page">
        <section class="m-card m-hero">
            <div>
                <small>Portfolio</small>
                <h1>{{ $displayName }}</h1>
                <p>{{ $portfolio->email }}</p>
            </div>
            @if ($pic)
                <img class="m-photo" src="{{ $pic }}" alt="Profile picture of {{ $portfolio->full_name }}">
            @else
                <div class="m-photo m-initial">{{ $initial }}</div>
            @endif
        </section>

        <section class="m-card m-contact">
            <h2>Contact</h2>
            <ul class="m-list">
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

        <section class="m-card m-edu">
            <h2>Education</h2>
            @foreach ($portfolio->educations as $edu)
                <div class="m-edu-item">
                    <strong>{{ $edu->school }}</strong>
                    @if ($edu->degree)<span>{{ $edu->degree }}</span>@endif
                    @if ($edu->start_year || $edu->end_year)<span>{{ $edu->start_year }} – {{ $edu->end_year }}</span>@endif
                </div>
            @endforeach
            @if (count($portfolio->educations) === 0)
                <p class="m-empty">No education added yet.</p>
            @endif
        </section>

        <section class="m-card m-skills">
            <h2>Skills</h2>
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
