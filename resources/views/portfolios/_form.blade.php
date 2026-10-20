@php
    $eduRows = old('educations', isset($portfolio) ? $portfolio->educations->map->only(['school','degree','level','start_year','end_year'])->values()->all() : []);
    $skillRows = old('skills', isset($portfolio) ? $portfolio->skills->map->only(['name'])->values()->all() : []);
    $eduCount = max(1, count($eduRows));
    $skillCount = max(2, count($skillRows));
    $levels = \App\Http\Controllers\PortfolioController::LEVELS;
@endphp

@push('styles')
<style>
    .field textarea,
    .field select { width: 100%; box-sizing: border-box; padding: 12px 14px; border-radius: 10px; border: 1px solid rgba(129,140,248,.4); background: #0b1230; color: #fff; font: inherit; }
    .field textarea { min-height: 130px; resize: vertical; }
    .field textarea:focus,
    .field select:focus { outline: 2px solid #22d3ee; border-color: #22d3ee; }
    .req-note { margin: 0 0 14px; color: #9aa5cf; font-size: .9rem; }
</style>
@endpush

@if ($errors->any())
    <div class="alert alert-danger">Please fix the errors below and try again.</div>
@endif

<p class="req-note">Fields marked with * are required.</p>

<div class="form-card">
    <h2 class="form-title">Personal Information</h2>
    <div class="form-grid">
        <div class="field full">
            <label for="full_name">Full Name *</label>
            <input type="text" id="full_name" name="full_name" required maxlength="120"
                   pattern="[A-Za-zÀ-ÿ .'\-]+" title="Letters, spaces, hyphens, apostrophes and periods only. No numbers."
                   value="{{ old('full_name', $portfolio->full_name ?? '') }}">
            @error('full_name')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="age">Age</label>
            <input type="text" id="age" name="age" inputmode="numeric" value="{{ old('age', $portfolio->age ?? '') }}">
            @error('age')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required maxlength="150" value="{{ old('email', $portfolio->email ?? '') }}">
            @error('email')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="contact_number">Contact Number *</label>
            <input type="text" id="contact_number" name="contact_number" required inputmode="tel" maxlength="20"
                   pattern="[0-9+\-\s\(\)]{7,20}" title="Numbers and the symbols + - ( ) only, 7 to 20 characters."
                   placeholder="+63 912 345 6789" value="{{ old('contact_number', $portfolio->contact_number ?? '') }}">
            @error('contact_number')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field full">
            <label for="address">Address *</label>
            <input type="text" id="address" name="address" required maxlength="255"
                   placeholder="Street, Barangay, City" value="{{ old('address', $portfolio->address ?? '') }}">
            @error('address')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field full">
            <label for="about">About Me *</label>
            <textarea id="about" name="about" required maxlength="1000" placeholder="Write a short introduction about yourself.">{{ old('about', $portfolio->about ?? '') }}</textarea>
            @error('about')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="facebook_link">Facebook Link</label>
            <input type="text" id="facebook_link" name="facebook_link" placeholder="https://facebook.com/yourname" value="{{ old('facebook_link', $portfolio->facebook_link ?? '') }}">
            @error('facebook_link')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field full">
            <label for="profile_picture">Profile Picture (optional: JPG, PNG, WEBP, max 2 MB)</label>
            @if (!empty($portfolio->profile_picture))
                <img class="current-pic" src="{{ asset('storage/' . $portfolio->profile_picture) }}" alt="Current picture">
            @endif
            <input type="file" id="profile_picture" name="profile_picture" accept="image/png,image/jpeg,image/webp">
            @error('profile_picture')<div class="error">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<div class="form-card">
    <h2 class="form-title">Education</h2>
    <p class="form-hint">The first row is required. Leave the other rows empty if you don't need them.</p>
    @for ($i = 0; $i < $eduCount; $i++)
        @php $row = $eduRows[$i] ?? []; $req = $i === 0; @endphp
        <div class="repeat-item">
            <div class="form-grid">
                <div class="field">
                    <label>School Name{{ $req ? ' *' : '' }}</label>
                    <input type="text" name="educations[{{ $i }}][school]" maxlength="150" {{ $req ? 'required' : '' }} value="{{ $row['school'] ?? '' }}">
                    @error("educations.$i.school")<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label>Course / Program{{ $req ? ' *' : '' }}</label>
                    <input type="text" name="educations[{{ $i }}][degree]" maxlength="150" {{ $req ? 'required' : '' }} value="{{ $row['degree'] ?? '' }}">
                    @error("educations.$i.degree")<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label>Education Level{{ $req ? ' *' : '' }}</label>
                    <select name="educations[{{ $i }}][level]" {{ $req ? 'required' : '' }}>
                        <option value="">Choose a level</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level }}" @selected(($row['level'] ?? '') === $level)>{{ $level }}</option>
                        @endforeach
                    </select>
                    @error("educations.$i.level")<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="field"><label>Start Year</label><input type="text" name="educations[{{ $i }}][start_year]" maxlength="10" value="{{ $row['start_year'] ?? '' }}"></div>
                <div class="field"><label>End Year</label><input type="text" name="educations[{{ $i }}][end_year]" maxlength="10" value="{{ $row['end_year'] ?? '' }}"></div>
            </div>
        </div>
    @endfor
</div>

<div class="form-card">
    <h2 class="form-title">Skills (optional)</h2>
    <p class="form-hint">Leave a box empty if you don't need it.</p>
    <div class="form-grid">
        @for ($i = 0; $i < $skillCount; $i++)
            @php $row = $skillRows[$i] ?? []; @endphp
            <div class="field">
                <label>Skill {{ $i + 1 }}</label>
                <input type="text" name="skills[{{ $i }}][name]" maxlength="60" value="{{ $row['name'] ?? '' }}">
            </div>
        @endfor
    </div>
</div>