<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

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
        $data['template'] = 'simple';
        $portfolio = Portfolio::create($data);

        return redirect()->route('portfolios.template', $portfolio)
            ->with('success', 'Information saved! Now choose a template.');
    }

    public function show(Portfolio $portfolio)
    {
        $template = in_array($portfolio->template, self::TEMPLATES) ? $portfolio->template : 'simple';
        return view('portfolios.show', compact('portfolio', 'template'));
    }

    public function edit(Portfolio $portfolio)
    {
        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $portfolio->update($this->validated($request));

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Portfolio updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
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
            'full_name' => ['required', 'string', 'max:120'],
            'age'       => ['nullable', 'integer', 'min:1', 'max:120'],
            'email'     => ['required', 'email', 'max:150'],
        ], [
            'full_name.required' => 'Please enter your name.',
            'age.integer'        => 'Age must be a number.',
            'age.min'            => 'Please enter a valid age.',
            'age.max'            => 'Please enter a valid age.',
            'email.required'     => 'Please enter your email address.',
            'email.email'        => 'Please enter a valid email address.',
        ]);
    }
}