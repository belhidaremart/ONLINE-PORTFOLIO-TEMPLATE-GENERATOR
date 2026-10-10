<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    private const TEMPLATES = ['simple', 'modern', 'creative'];

    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(9);
        return view('portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('portfolios.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $portfolio = DB::transaction(function () use ($request, $data) {
            $fields = $this->mainFields($data);
            $fields['template'] = 'simple';

            if ($request->hasFile('profile_picture')) {
                $fields['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
            }

            $portfolio = Portfolio::create($fields);
            $this->saveRelated($portfolio, $data);
            return $portfolio;
        });

        return redirect()->route('portfolios.template', $portfolio)
            ->with('success', 'Information saved! Now choose a template.');
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load(['educations', 'skills', 'projects', 'workExperiences']);
        $template = in_array($portfolio->template, self::TEMPLATES) ? $portfolio->template : 'simple';
        return view('portfolios.show', compact('portfolio', 'template'));
    }

    public function edit(Portfolio $portfolio)
    {
        $portfolio->load(['educations', 'skills', 'projects', 'workExperiences']);
        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($request, $data, $portfolio) {
            $fields = $this->mainFields($data);

            if ($request->hasFile('profile_picture')) {
                if ($portfolio->profile_picture) {
                    Storage::disk('public')->delete($portfolio->profile_picture);
                }
                $fields['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
            }

            $portfolio->update($fields);

            $portfolio->educations()->delete();
            $portfolio->skills()->delete();
            $portfolio->projects()->delete();
            $portfolio->workExperiences()->delete();
            $this->saveRelated($portfolio, $data);
        });

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Portfolio updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->profile_picture) {
            Storage::disk('public')->delete($portfolio->profile_picture);
        }

        $portfolio->delete();

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio deleted.');
    }

    public function template(Portfolio $portfolio)
    {
        return view('portfolios.template', compact('portfolio'));
    }

    public function updateTemplate(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'template' => ['required', 'in:simple,modern,creative'],
        ], [
            'template.in' => 'Please choose one of the three templates.',
        ]);

        $portfolio->update(['template' => $request->template]);

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Template selected. Here is your portfolio!');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'full_name'       => ['required', 'string', 'max:120'],
            'job_title'       => ['nullable', 'string', 'max:120'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'email'           => ['required', 'email', 'max:150'],
            'contact_number'  => ['nullable', 'string', 'max:30'],
            'address'         => ['nullable', 'string', 'max:255'],
            'about_me'        => ['nullable', 'string', 'max:3000'],

            'facebook_link'  => ['nullable', 'url', 'max:255'],
            'instagram_link' => ['nullable', 'url', 'max:255'],
            'linkedin_link'  => ['nullable', 'url', 'max:255'],
            'github_link'    => ['nullable', 'url', 'max:255'],
            'website_link'   => ['nullable', 'url', 'max:255'],

            'educations'              => ['nullable', 'array', 'max:10'],
            'educations.*.school'     => ['nullable', 'string', 'max:150'],
            'educations.*.degree'     => ['nullable', 'string', 'max:150'],
            'educations.*.start_year' => ['nullable', 'string', 'max:10'],
            'educations.*.end_year'   => ['nullable', 'string', 'max:10'],

            'skills'        => ['nullable', 'array', 'max:30'],
            'skills.*.name' => ['nullable', 'string', 'max:60'],

            'projects'               => ['nullable', 'array', 'max:10'],
            'projects.*.title'       => ['nullable', 'string', 'max:150'],
            'projects.*.description' => ['nullable', 'string', 'max:1000'],
            'projects.*.link'        => ['nullable', 'url', 'max:255'],

            'work_experiences'               => ['nullable', 'array', 'max:10'],
            'work_experiences.*.company'     => ['nullable', 'string', 'max:150'],
            'work_experiences.*.position'    => ['nullable', 'string', 'max:150'],
            'work_experiences.*.start_year'  => ['nullable', 'string', 'max:10'],
            'work_experiences.*.end_year'    => ['nullable', 'string', 'max:10'],
            'work_experiences.*.description' => ['nullable', 'string', 'max:1000'],
        ], [
            'full_name.required'    => 'Please enter your full name.',
            'email.required'        => 'Please enter your email address.',
            'email.email'           => 'Please enter a valid email address.',
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'Allowed picture types: JPG, PNG, or WEBP.',
            'profile_picture.max'   => 'The picture must be 2 MB or smaller.',
            '*.url'                 => 'Please enter a full link starting with https://',
        ]);
    }

    private function mainFields(array $data): array
    {
        return collect($data)->only([
            'full_name', 'job_title', 'email', 'contact_number', 'address', 'about_me',
            'facebook_link', 'instagram_link', 'linkedin_link', 'github_link', 'website_link',
        ])->toArray();
    }

    private function saveRelated(Portfolio $portfolio, array $data): void
    {
        foreach ($data['educations'] ?? [] as $row) {
            if (!empty($row['school'])) {
                $portfolio->educations()->create($row);
            }
        }

        foreach ($data['skills'] ?? [] as $row) {
            if (!empty($row['name'])) {
                $portfolio->skills()->create(['name' => $row['name']]);
            }
        }

        foreach ($data['projects'] ?? [] as $row) {
            if (!empty($row['title'])) {
                $portfolio->projects()->create($row);
            }
        }

        foreach ($data['work_experiences'] ?? [] as $row) {
            if (!empty($row['company'])) {
                $portfolio->workExperiences()->create($row);
            }
        }
    }
}