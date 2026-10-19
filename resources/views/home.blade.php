@extends('layouts.app')

@section('title', 'Portfolio Template Generator')

@section('content')

    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="hero-badge">Free portfolio builder</span>
                <h1>Build your <span>online portfolio</span> in minutes</h1>
                <p class="lead">
                    Enter your details once, choose one of three professional templates,
                    and get a ready-to-share portfolio page. No coding needed.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('portfolios.create') }}" class="btn btn-primary">Create My Portfolio</a>
                    <a href="{{ route('portfolios.index') }}" class="btn btn-outline">Manage Portfolios</a>
                </div>
            </div>

            <div class="hero-visual" aria-hidden="true">
                <div class="mock-card">
                    <div class="mock-head">
                        <div class="mock-avatar"></div>
                        <div style="flex:1">
                            <div class="mock-line dark w-60"></div>
                            <div class="mock-line w-40"></div>
                        </div>
                    </div>
                    <div class="mock-line"></div>
                    <div class="mock-line w-80"></div>
                    <div class="mock-line w-60"></div>
                    <div class="mock-tags">
                        <span class="mock-tag">Simple</span>
                        <span class="mock-tag">Modern</span>
                        <span class="mock-tag">Creative</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-white" id="how-it-works">
        <div class="container">
            <div class="section-head">
                <h2>How it works</h2>
                <p>Four simple steps take you from empty form to finished portfolio.</p>
            </div>

            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Enter your information</h3>
                    <p>Fill in your name, age, and email.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Save it online</h3>
                    <p>Your information is stored safely in an online database.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Choose a template</h3>
                    <p>Pick Simple, Modern, or Creative. Each has its own layout.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h3>Preview and manage</h3>
                    <p>View your portfolio, edit it, switch templates, or delete it anytime.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Three templates, three different looks</h2>
                <p>Not just different colors. Each template arranges your content in its own way.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <span class="tag">Template 1</span>
                    <h3>Simple</h3>
                    <p>Clean white layout with minimal styling. Great for students and job applicants.</p>
                </div>
                <div class="feature-card">
                    <span class="tag">Template 2</span>
                    <h3>Modern</h3>
                    <p>Soft gradient background with rounded cards and subtle shadows.</p>
                </div>
                <div class="feature-card">
                    <span class="tag">Template 3</span>
                    <h3>Creative</h3>
                    <p>A bold, distinctive layout with strong typography and accent colors.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="cta-band">
                <h2>Ready to show your work?</h2>
                <p>Start now and have your portfolio ready in just a few minutes.</p>
                <a href="{{ route('portfolios.create') }}" class="btn">Create My Portfolio</a>
            </div>
        </div>
    </section>

@endsection