<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(Request $request): View
    {
        $teams = Team::all();

        return view('team.index', compact('teams'));
    }

    public function create(Request $request): View
    {
        return view('team.create');
    }

    public function store(TeamStoreRequest $request): RedirectResponse
    {
        $team = Team::create($request->validated());

        $request->session()->flash('team.id', $team->id);

        return redirect()->route('team.index');
    }

    public function show(Request $request, Team $team): View
    {
        return view('team.show', compact('team'));
    }

    public function edit(Request $request, Team $team): View
    {
        return view('team.edit', compact('team'));
    }

    public function update(TeamUpdateRequest $request, Team $team): RedirectResponse
    {
        $team->update($request->validated());

        $request->session()->flash('team.id', $team->id);

        return redirect()->route('team.index');
    }

    public function destroy(Request $request, Team $team): RedirectResponse
    {
        $team->delete();

        return redirect()->route('team.index');
    }
}
