<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    private const TEMPLATES = ['simple', 'modern', 'creative'];

    public const LEVELS = [
        'Elementary',
        'High School',
        'Senior High School',
        'Vocational / TESDA',
        "College / Bachelor's Degree",
        "Master's Degree",
        'Doctorate',
    ];

    public function index(Request $request)
    {
        $portfolios = $request->user()->portfolios()->latest()->paginate(9);
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

            $portfolio = $request->user()->portfolios()->create($fields);
            $this->saveRelated($portfolio, $data);
            return $portfolio;
        });

        return redirect()->route('portfolios.template', $portfolio)
            ->with('success', 'Information saved! Now choose a template.');
    }

    public function show(Request $request, Portfolio $portfolio)
    {
        $this->owned($portfolio);

        $portfolio->load(['educations', 'skills']);
        $saved = in_array($portfolio->template, self::TEMPLATES) ? $portfolio->template : 'simple';
        $template = in_array($request->query('template'), self::TEMPLATES) ? $request->query('template') : $saved;
        $embed = $request->boolean('embed');

        return view('portfolios.show', compact('portfolio', 'template', 'saved', 'embed'));
    }

    public function edit(Portfolio $portfolio)
    {
        $this->owned($portfolio);

        $portfolio->load(['educations', 'skills']);
        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->owned($portfolio);

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
        $this->owned($portfolio);

        if ($portfolio->profile_picture) {
            Storage::disk('public')->delete($portfolio->profile_picture);
        }

        $portfolio->delete();

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio deleted.');
    }

    public function template(Portfolio $portfolio)
    {
        $this->owned($portfolio);

        return view('portfolios.template', compact('portfolio'));
    }

    public function updateTemplate(Request $request, Portfolio $portfolio)
    {
        $this->owned($portfolio);

        $request->validate([
            'template' => ['required', 'in:simple,modern,creative'],
        ], [
            'template.in' => 'Please choose one of the three templates.',
        ]);

        $portfolio->update(['template' => $request->template]);

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Template selected. Here is your portfolio!');
    }

    // Only the owner of a portfolio may open or change it.
    private function owned(Portfolio $portfolio): void
    {
        abort_unless((int) $portfolio->user_id === (int) auth()->id(), 404);
    }

    private function validated(Request $request): array
    {
        $rules = [
            'full_name'       => ['required', 'string', 'max:120', 'regex:/^[\p{L}\p{M}\s.\'\-]+$/u'],
            'age'             => ['nullable', 'integer', 'min:1', 'max:120'],
            'email'           => ['required', 'email', 'max:150'],
            'contact_number'  => ['required', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'address'         => ['required', 'string', 'max:255', 'regex:/^[\p{L}\p{N}\s.,#\/\'()\-]+$/u'],
            'about'           => ['required', 'string', 'max:1000'],
            'facebook_link'   => ['nullable', 'url', 'max:255'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'educations' => ['required', 'array', 'max:10'],

            'skills'        => ['nullable', 'array', 'max:30'],
            'skills.*.name' => ['nullable', 'string', 'max:60'],
        ];

        // The first education row is required. The other rows are optional.
        foreach (range(0, 9) as $i) {
            $first = $i === 0 ? 'required' : 'nullable';

            $rules["educations.$i.school"]     = [$first, 'string', 'max:150'];
            $rules["educations.$i.degree"]     = [$first, 'string', 'max:150'];
            $rules["educations.$i.level"]      = [$first, 'string', Rule::in(self::LEVELS)];
            $rules["educations.$i.start_year"] = ['nullable', 'string', 'max:10'];
            $rules["educations.$i.end_year"]   = ['nullable', 'string', 'max:10'];
        }

        return $request->validate($rules, [
            'full_name.required'    => 'Please enter your name.',
            'full_name.regex'       => 'The name can only have letters, spaces, hyphens, apostrophes and periods. No numbers.',
            'age.integer'           => 'Age must be a number.',
            'email.required'        => 'Please enter your email address.',
            'email.email'           => 'Please enter a valid email address.',
            'contact_number.required' => 'Please enter your contact number.',
            'contact_number.regex'  => 'Use numbers and the symbols + - ( ) only, 7 to 20 characters.',
            'address.required'      => 'Please enter your address.',
            'address.regex'         => 'The address has characters that are not allowed.',
            'about.required'        => 'Please write a short text about yourself.',
            'about.max'             => 'About Me must be 1000 characters or less.',
            'facebook_link.url'     => 'Enter the full link, starting with https://',
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'Allowed picture types: JPG, PNG, or WEBP.',
            'profile_picture.max'   => 'The picture must be 2 MB or smaller.',
            'educations.0.school.required' => 'Please enter your school name.',
            'educations.0.degree.required' => 'Please enter your course or program.',
            'educations.0.level.required'  => 'Please choose your education level.',
            'educations.0.level.in'        => 'Please choose a level from the list.',
        ]);
    }

    private function mainFields(array $data): array
    {
        return collect($data)->only([
            'full_name', 'age', 'email', 'contact_number', 'address', 'about', 'facebook_link',
        ])->toArray();
    }

    private function saveRelated(Portfolio $portfolio, array $data): void
    {
        foreach ($data['educations'] ?? [] as $row) {
            if (!empty($row['school'])) {
                $portfolio->educations()->forceCreate($row);
            }
        }

        foreach ($data['skills'] ?? [] as $row) {
            if (!empty($row['name'])) {
                $portfolio->skills()->create(['name' => $row['name']]);
            }
        }
    }
}