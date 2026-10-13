@php
    $educations = old('educations', isset($portfolio) ? $portfolio->educations->map->only(['school','degree','start_year','end_year'])->values()->all() : []);
    $skills = old('skills', isset($portfolio) ? $portfolio->skills->map->only(['name'])->values()->all() : []);
    if (!count($educations)) $educations = [[]];
    if (!count($skills)) $skills = [[]];
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
    <div id="educations-list">
        @foreach ($educations as $i => $row)
            <div class="repeat-item">
                <div class="form-grid">
                    <div class="field"><label>School</label><input type="text" name="educations[{{ $i }}][school]" value="{{ $row['school'] ?? '' }}"></div>
                    <div class="field"><label>Degree / Course</label><input type="text" name="educations[{{ $i }}][degree]" value="{{ $row['degree'] ?? '' }}"></div>
                    <div class="field"><label>Start Year</label><input type="text" name="educations[{{ $i }}][start_year]" value="{{ $row['start_year'] ?? '' }}"></div>
                    <div class="field"><label>End Year</label><input type="text" name="educations[{{ $i }}][end_year]" value="{{ $row['end_year'] ?? '' }}"></div>
                </div>
                <button type="button" class="btn btn-sm btn-outline remove-btn">Remove</button>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-sm btn-outline add-btn" data-target="educations-list" data-template="tpl-education">+ Add Education</button>
</div>

<div class="form-card">
    <h2 class="form-title">Skills</h2>
    <div id="skills-list">
        @foreach ($skills as $i => $row)
            <div class="repeat-item">
                <div class="field"><label>Skill</label><input type="text" name="skills[{{ $i }}][name]" value="{{ $row['name'] ?? '' }}"></div>
                <button type="button" class="btn btn-sm btn-outline remove-btn">Remove</button>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-sm btn-outline add-btn" data-target="skills-list" data-template="tpl-skill">+ Add Skill</button>
</div>

<template id="tpl-education">
    <div class="repeat-item">
        <div class="form-grid">
            <div class="field"><label>School</label><input type="text" name="educations[__i__][school]"></div>
            <div class="field"><label>Degree / Course</label><input type="text" name="educations[__i__][degree]"></div>
            <div class="field"><label>Start Year</label><input type="text" name="educations[__i__][start_year]"></div>
            <div class="field"><label>End Year</label><input type="text" name="educations[__i__][end_year]"></div>
        </div>
        <button type="button" class="btn btn-sm btn-outline remove-btn">Remove</button>
    </div>
</template>
<template id="tpl-skill">
    <div class="repeat-item">
        <div class="field"><label>Skill</label><input type="text" name="skills[__i__][name]"></div>
        <button type="button" class="btn btn-sm btn-outline remove-btn">Remove</button>
    </div>
</template>