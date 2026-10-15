@extends('layouts.app')

@section('title', 'Choose a Template')

@section('content')
<section class="page">
    <div class="container">
        <h1 class="page-title">Choose a Template</h1>
                        <p class="page-sub">Pick the look for your portfolio. You can change it later.</p>
        @error('template')<div class="alert alert-danger">{{ $message }}</div>@enderror

        <form action="{{ route('portfolios.template.update', $portfolio) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="template-grid">
                @php
                    $options = [
                        'simple'   => ['Simple', 'Clean white layout with minimal styling. Great for students and job applicants.'],
                        'modern'   => ['Modern', 'Soft gradient background with rounded cards and subtle shadows.'],
                        'creative' => ['Creative', 'Bold, distinctive layout with strong typography and accent colors.'],
                    ];
                @endphp

                @foreach ($options as $key => [$name, $desc])
                    <label class="template-card">
                        <input type="radio" name="template" value="{{ $key }}" {{ old('template', $portfolio->template) === $key ? 'checked' : '' }}>
                        <div class="template-body">
                            <div class="tpl-preview tpl-{{ $key }}">
                                <span class="tp-bar"></span>
                                <span class="tp-line"></span>
                                <span class="tp-line short"></span>
                                <span class="tp-block"></span>
                            </div>
                            <h3>{{ $name }}</h3>
                            <p>{{ $desc }}</p>
                            <span class="btn btn-sm btn-outline choose-label">Choose Template</span>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="form-actions" style="margin-top:32px">
                <a href="{{ route('portfolios.index') }}" class="btn btn-outline">Back</a>
                <button type="submit" class="btn btn-primary">Generate Portfolio</button>
            </div>
        </form>
    </div>
</section>
@endsection