<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Task;
use App\Models\Users;
use App\Models\Trainings;
use App\Models\PmStatus;

class DashboardController extends Controller
{
    public function dashboard(){
        $userId = Auth::id();

        // Get user's team IDs
        $userTeamIds = DB::table('teams_users')
            ->where('user_id', $userId)
            ->whereNull('deleted_at')
            ->pluck('team_id');

        // KPI 1: Active Projects (from user's teams)
        $activeProjects = Project::whereIn('id', function($query) use ($userId) {
                $query->select('project_id')
                    ->from('teams_projects')
                    ->whereNull('teams_projects.deleted_at')
                    ->whereIn('team_id', function($subQuery) use ($userId) {
                        $subQuery->select('team_id')
                            ->from('teams_users')
                            ->where('user_id', $userId)
                            ->whereNull('teams_users.deleted_at');
                    });
            })
            ->count();

        // KPI 2: My Tasks (assigned to user)
        $myTasks = Task::whereIn('id', function($query) use ($userId) {
                $query->select('task_id')
                    ->from('task_users')
                    ->where('user_id', $userId)
                    ->whereNull('deleted_at');
            })
            ->where('task_status', '!=', 'Concluído')
            ->where('task_status', '!=', 'Cancelado')
            ->count();

        // KPI 3: Team Members (unique users across all user's teams)
        $teamMembers = Users::whereIn('id', function($query) use ($userId) {
                $query->select('user_id')
                    ->from('teams_users')
                    ->whereNull('deleted_at')
                    ->whereIn('team_id', function($subQuery) use ($userId) {
                        $subQuery->select('team_id')
                            ->from('teams_users')
                            ->where('user_id', $userId)
                            ->whereNull('deleted_at');
                    });
            })
            ->count();

        // KPI 4: Available Trainings (from user's teams)
        $availableTrainings = Trainings::whereIn('id', function($query) use ($userId) {
                $query->select('training_id')
                    ->from('training_teams')
                    ->whereNull('training_teams.deleted_at')
                    ->whereIn('team_id', function($subQuery) use ($userId) {
                        $subQuery->select('team_id')
                            ->from('teams_users')
                            ->where('user_id', $userId)
                            ->whereNull('teams_users.deleted_at');
                    });
            })
            ->count();

        // My Priority Tasks (assigned to user, not completed) - ordered by priority
        $myPriorityTasks = Task::select('tasks.*', 'projects.project_designation')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->whereIn('tasks.id', function($query) use ($userId) {
                $query->select('task_id')
                    ->from('task_users')
                    ->where('user_id', $userId)
                    ->whereNull('deleted_at');
            })
            ->whereNotIn('tasks.task_status', ['Concluído', 'Cancelado'])
            ->orderByRaw("CASE
                WHEN tasks.task_status = 'Em Curso' THEN 1
                WHEN tasks.task_status = 'Em Pausa' THEN 2
                WHEN tasks.task_status = 'Pendente' THEN 3
                WHEN tasks.task_status = 'A Fazer' THEN 4
                ELSE 5
            END")
            ->orderBy('tasks.created_at', 'desc')
            ->limit(10)
            ->get();

        // Get all statuses for dropdown
        $statuses = PmStatus::all();

        return view("dashboard", [
            'activeProjects' => $activeProjects,
            'myTasks' => $myTasks,
            'teamMembers' => $teamMembers,
            'availableTrainings' => $availableTrainings,
            'myPriorityTasks' => $myPriorityTasks,
            'statuses' => $statuses
        ]);
    }
}
