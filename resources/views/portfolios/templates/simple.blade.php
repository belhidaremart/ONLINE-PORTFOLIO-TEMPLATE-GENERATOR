<style>
    .s-wrap { min-height: 100vh; padding: 48px 20px; background: #e9ecf2; color: #1f2937; font-family: Georgia, "Times New Roman", serif; }
    .s-page { max-width: 920px; margin: 0 auto; display: grid; grid-template-columns: 290px 1fr; background: #fff; box-shadow: 0 12px 40px rgba(20,33,61,.18); }
    .s-side { padding: 40px 28px; background: #14213d; color: #e5e7eb; font-family: Arial, sans-serif; }
    .s-photo { display: block; width: 150px; height: 150px; margin: 0 auto 28px; object-fit: cover; border: 3px solid #c9a227; }
    .s-initial { display: flex; align-items: center; justify-content: center; background: #1d2f57; color: #c9a227; font-family: Georgia, serif; font-size: 4.2rem; }
    .s-side h2 { margin: 26px 0 12px; padding-bottom: 6px; border-bottom: 1px solid rgba(201,162,39,.6); color: #c9a227; font-size: .78rem; letter-spacing: .18em; text-transform: uppercase; }
    .s-list { margin: 0; padding: 0; list-style: none; font-size: .9rem; line-height: 1.5; }
    .s-list li { margin-bottom: 12px; word-break: break-word; }
    .s-list small { display: block; color: #9ca3af; font-size: .68rem; letter-spacing: .1em; text-transform: uppercase; }
    .s-side a { color: #fff; text-decoration: none; }
    .s-skills { margin: 0; padding: 0; list-style: none; font-size: .9rem; }
    .s-skills li { margin-bottom: 8px; padding-left: 14px; position: relative; }
    .s-skills li::before { content: ""; position: absolute; left: 0; top: .5em; width: 6px; height: 6px; background: #c9a227; transform: rotate(45deg); }
    .s-main { padding: 48px 44px; }
    .s-main h1 { margin: 0; font-size: 2.6rem; line-height: 1.1; color: #14213d; word-break: break-word; }
    .s-role { margin: 10px 0 0; color: #c9a227; font-family: Arial, sans-serif; font-size: .8rem; letter-spacing: .22em; text-transform: uppercase; }
    .s-rule { width: 70px; height: 3px; margin: 22px 0 30px; background: #c9a227; }
    .s-main h2 { margin: 0 0 16px; color: #14213d; font-family: Arial, sans-serif; font-size: .85rem; letter-spacing: .18em; text-transform: uppercase; }
    .s-edu { margin-bottom: 20px; padding-left: 18px; border-left: 3px solid #c9a227; }
    .s-edu strong { display: block; font-size: 1.15rem; color: #14213d; }
    .s-edu span { display: block; color: #4b5563; font-family: Arial, sans-serif; font-size: .92rem; margin-top: 2px; }
    .s-empty { margin: 0; color: #9ca3af; font-style: italic; font-family: Arial, sans-serif; font-size: .9rem; }
    @media (max-width: 760px) {
        .s-page { grid-template-columns: 1fr; }
        .s-main { padding: 30px 22px; }
    }
</style>

<div class="s-wrap">
    <div class="s-page">
        <aside class="s-side">
            @if ($pic)
                <img class="s-photo" src="{{ $pic }}" alt="Profile picture of {{ $portfolio->full_name }}">
            @else
                <div class="s-photo s-initial">{{ $initial }}</div>
            @endif

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

            <h2>Skills</h2>
            <ul class="s-skills">
                @foreach ($portfolio->skills as $skill)
                    <li>{{ $skill->name }}</li>
                @endforeach
            </ul>
            @if (count($portfolio->skills) === 0)
                <p class="s-list">No skills added yet.</p>
            @endif
        </aside>

        <main class="s-main">
            <h1>{{ $displayName }}</h1>
            <p class="s-role">Professional Profile</p>
            <div class="s-rule"></div>

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
        </main>
    </div>
</div>
