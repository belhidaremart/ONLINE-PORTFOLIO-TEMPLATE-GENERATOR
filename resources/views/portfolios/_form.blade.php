@php
    $eduRows = old('educations', isset($portfolio) ? $portfolio->educations->map->only(['school','degree','start_year','end_year'])->values()->all() : []);
    $skillRows = old('skills', isset($portfolio) ? $portfolio->skills->map->only(['name'])->values()->all() : []);
    $eduCount = max(1, count($eduRows));
    $skillCount = max(2, count($skillRows));
@endphp

@if ($errors->any())
    <div class="alert alert-danger">Please fix the errors below and try again.</div>
@endif

<div class="form-card">
    <h2 class="form-title">Personal Information</h2>
    <div class="form-grid">
        <div class="field full">
            <label for="full_name">Name *</label>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $portfolio->full_name ?? '') }}">
            @error('full_name')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="age">Age</label>
            <input type="text" id="age" name="age" value="{{ old('age', $portfolio->age ?? '') }}">
            @error('age')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email', $portfolio->email ?? '') }}">
            @error('email')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="contact_number">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number', $portfolio->contact_number ?? '') }}">
            @error('contact_number')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="facebook_link">Facebook Link</label>
            <input type="text" id="facebook_link" name="facebook_link" placeholder="https://facebook.com/yourname" value="{{ old('facebook_link', $portfolio->facebook_link ?? '') }}">
            @error('facebook_link')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field full">
            <label for="profile_picture">Profile Picture (JPG, PNG, WEBP, max 2 MB)</label>
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
    <p class="form-hint">Leave a row empty if you don't need it.</p>
    @for ($i = 0; $i < $eduCount; $i++)
        @php $row = $eduRows[$i] ?? []; @endphp
        <div class="repeat-item">
            <div class="form-grid">
                <div class="field"><label>School</label><input type="text" name="educations[{{ $i }}][school]" value="{{ $row['school'] ?? '' }}"></div>
                <div class="field"><label>Degree / Course</label><input type="text" name="educations[{{ $i }}][degree]" value="{{ $row['degree'] ?? '' }}"></div>
                <div class="field"><label>Start Year</label><input type="text" name="educations[{{ $i }}][start_year]" value="{{ $row['start_year'] ?? '' }}"></div>
                <div class="field"><label>End Year</label><input type="text" name="educations[{{ $i }}][end_year]" value="{{ $row['end_year'] ?? '' }}"></div>
            </div>
        </div>
    @endfor
</div>

<div class="form-card">
    <h2 class="form-title">Skills</h2>
    <p class="form-hint">Leave a box empty if you don't need it.</p>
    <div class="form-grid">
        @for ($i = 0; $i < $skillCount; $i++)
            @php $row = $skillRows[$i] ?? []; @endphp
            <div class="field">
                <label>Skill {{ $i + 1 }}</label>
                <input type="text" name="skills[{{ $i }}][name]" value="{{ $row['name'] ?? '' }}">
            </div>
        @endfor
    </div>
</div>