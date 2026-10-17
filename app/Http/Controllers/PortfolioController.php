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

    public function show(Request $request, Portfolio $portfolio)
    {
        $portfolio->load(['educations', 'skills']);

        $saved = in_array($portfolio->template, self::TEMPLATES) ? $portfolio->template : 'simple';
        $template = in_array($request->query('template'), self::TEMPLATES) ? $request->query('template') : $saved;
        $embed = $request->boolean('embed');

        return view('portfolios.show', compact('portfolio', 'template', 'saved', 'embed'));
    }

    public function edit(Portfolio $portfolio)
    {
        $portfolio->load(['educations', 'skills']);
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
            'age'             => ['nullable', 'integer', 'min:1', 'max:120'],
            'email'           => ['required', 'email', 'max:150'],
            'contact_number'  => ['nullable', 'string', 'max:30'],
            'facebook_link'   => ['nullable', 'url', 'max:255'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'educations'              => ['nullable', 'array', 'max:10'],
            'educations.*.school'     => ['nullable', 'string', 'max:150'],
            'educations.*.degree'     => ['nullable', 'string', 'max:150'],
            'educations.*.start_year' => ['nullable', 'string', 'max:10'],
            'educations.*.end_year'   => ['nullable', 'string', 'max:10'],

            'skills'        => ['nullable', 'array', 'max:30'],
            'skills.*.name' => ['nullable', 'string', 'max:60'],
        ], [
            'full_name.required'    => 'Please enter your name.',
            'age.integer'           => 'Age must be a number.',
            'email.required'        => 'Please enter your email address.',
            'email.email'           => 'Please enter a valid email address.',
            'facebook_link.url'     => 'Enter the full link, starting with https://',
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'Allowed picture types: JPG, PNG, or WEBP.',
            'profile_picture.max'   => 'The picture must be 2 MB or smaller.',
        ]);
    }

    private function mainFields(array $data): array
    {
        return collect($data)->only([
            'full_name', 'age', 'email', 'contact_number', 'facebook_link',
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
    }
}