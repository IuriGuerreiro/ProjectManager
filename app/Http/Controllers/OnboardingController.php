<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teams;
use App\Models\Teams_users;

class OnboardingController extends Controller
{
    /**
     * Show step 1: Organization info
     */
    public function step1()
    {
        return view('onboarding.step1');
    }

    /**
     * Process step 1 and redirect to step 2
     */
    public function processStep1(Request $request)
    {
        $request->validate([
            'organization_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->organization_name = $request->organization_name;
        $user->position = $request->position;
        $user->save();

        return redirect()->route('onboarding.step2');
    }

    /**
     * Show step 2: Team setup
     */
    public function step2()
    {
        $existingTeams = Teams::all();
        return view('onboarding.step2', compact('existingTeams'));
    }

    /**
     * Process step 2 and complete onboarding
     */
    public function processStep2(Request $request)
    {
        $request->validate([
            'team_action' => 'required|in:create,join',
            'new_team_name' => 'required_if:team_action,create|nullable|string|max:255',
            'existing_team_id' => 'required_if:team_action,join|nullable|exists:teams,id',
        ]);

        $user = Auth::user();

        if ($request->team_action === 'create') {
            // Create new team
            $team = Teams::create([
                'team_designation' => $request->new_team_name,
            ]);

            // Add user to the new team
            Teams_users::create([
                'user_id' => $user->id,
                'team_id' => $team->id,
            ]);
        } else {
            // Join existing team
            Teams_users::create([
                'user_id' => $user->id,
                'team_id' => $request->existing_team_id,
            ]);
        }

        // Mark onboarding as completed
        $user->onboarding_completed = true;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Onboarding concluído! Bem-vindo ao sistema.');
    }

    /**
     * Skip onboarding (optional)
     */
    public function skip()
    {
        $user = Auth::user();
        $user->onboarding_completed = true;
        $user->save();

        return redirect()->route('dashboard')->with('info', 'Pode completar o seu perfil mais tarde.');
    }
}
