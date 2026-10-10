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
    </div>
</div>