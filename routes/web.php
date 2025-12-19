<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectUsersController;
use App\Http\Controllers\TasksUsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamProjectController;
use App\Http\Controllers\TrainingsController;
use App\Http\Controllers\FormersController;
use App\Http\Controllers\TrainingUserscontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OnboardingController;
use Illuminate\Support\Facades\Route;

// Public route - redirects to login if not authenticated
Route::get('/', function () {
    return redirect()->route('login');
});

// Onboarding routes - require auth but not onboarding completion
Route::middleware(['auth', 'verified'])->prefix('onboarding')->group(function () {
    Route::get('/step1', [OnboardingController::class, 'step1'])->name('onboarding.step1');
    Route::post('/step1', [OnboardingController::class, 'processStep1'])->name('onboarding.processStep1');
    Route::get('/step2', [OnboardingController::class, 'step2'])->name('onboarding.step2');
    Route::post('/step2', [OnboardingController::class, 'processStep2'])->name('onboarding.processStep2');
    Route::get('/skip', [OnboardingController::class, 'skip'])->name('onboarding.skip');
});

// Protected routes - require authentication, email verification, and completed onboarding
Route::middleware(['auth', 'verified', 'onboarding'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Projects
    Route::prefix('Project')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.list');
        Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/store', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::post('/update/{id}', [ProjectController::class, 'update'])->name('projects.update');
        Route::get('/view/{id}', [ProjectController::class, 'view'])->name('projects.view');
        Route::get('/delete/{id}', [ProjectController::class, 'delete'])->name('projects.delete');
    });

    // Tasks
    Route::prefix('task')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.list');
        Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::post('/update/{id}', [TaskController::class, 'update'])->name('tasks.update');
        Route::get('/view/{id}', [TaskController::class, 'view'])->name('tasks.view');
        Route::get('/delete/{id}', [TaskController::class, 'delete'])->name('tasks.delete');
        Route::get('/listProject/{project_id}', [TaskController::class, 'listByProject'])->name('tasks.listbyProject');
    });

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.list');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/view/{id}', [UserController::class, 'view'])->name('users.view');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
        Route::get('/listProject/{project_id}', [TaskController::class, 'listByProject'])->name('users.listbyProject');

        // Task assignments
        Route::get('/AdduserToTask/{project_id}', [TasksUsersController::class, 'AddToTask'])->name('users.AddToTask');
        Route::post('/AddTaskTouser/Store/{project_id}', [TasksUsersController::class, 'store'])->name('users.storeToTasks');
        Route::get('/removeTaskTouser/{id}', [TasksUsersController::class, 'remove'])->name('users.removeFromTask');
        Route::get('/removeuserToTask/{id}', [TasksUsersController::class, 'remove'])->name('users.removeuserToTask');

        // Role management
        Route::get('/addrole{user_id}', [RoleController::class, 'addRole'])->name('users.addRole');
        Route::post('/addrole/store/{user_id}', [RoleController::class, 'storeRole'])->name('users.storeRole');
        Route::get('/removeRole/{id}', [RoleController::class, 'removeRole'])->name('users.removeRole');
    });

    // Teams
    Route::prefix('teams')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('teams.list');
        Route::get('/create', [TeamController::class, 'create'])->name('teams.create');
        Route::post('/store', [TeamController::class, 'store'])->name('teams.store');
        Route::get('/view/{team_id}', [TeamController::class, 'view'])->name('teams.view');
        Route::get('/edit/{team_id}', [TeamController::class, 'edit'])->name('teams.edit');
        Route::post('/update/{team_id}', [TeamController::class, 'update'])->name('teams.update');
        Route::get('/delete/{team_id}', [TeamController::class, 'delete'])->name('teams.delete');
        Route::get('/addUser/{user_id}', [TeamController::class, 'AddUser'])->name('teams.AddUser');
        Route::post('/addUser/store/{team_id}', [TeamController::class, 'storeUser'])->name('teams.storeUser');
        Route::get('/removeUser/{user_id}', [TeamController::class, 'removerUser'])->name('teams.removerUser');
        Route::get('/AdduserToTeam/{team_id}', [TeamController::class, 'AddToTeam'])->name('teams.AddToTeam');
        Route::post('/AddTeamTouser/Store/{team_id}', [TeamController::class, 'store'])->name('teams.storeToTeam');
        Route::get('/AddProjectToTeam/{project_id}', [TeamProjectController::class, 'AddProjectToTeam'])->name('teams.AddProjectToTeam');
        Route::post('/AddProjectToTeam/Store/{project_id}', [TeamProjectController::class, 'storeProjectToTeam'])->name('teams.storeProjectToTeam');
        Route::get('/AdduserToProject/{team_id}', [TeamProjectController::class, 'addTeamToProject'])->name('teams.addTeamToProject');
        Route::post('/AdduserToProject/store/{user_id}', [TeamProjectController::class, 'storeTeamToProject'])->name('teams.storeTeamToProject');
        Route::get('/TeamFromProject/{Teams_project_id}', [TeamProjectController::class, 'remove'])->name('teams.removeProject');

        // Invite functionality
        Route::get('/invite/{token}', [TeamController::class, 'showInvite'])->name('teams.showInvite');
        Route::post('/invite/{token}/join', [TeamController::class, 'joinViaInvite'])->name('teams.joinViaInvite');
        Route::post('/regenerate-invite/{team_id}', [TeamController::class, 'regenerateInviteToken'])->name('teams.regenerateInvite');
    });

    // Trainings
    Route::prefix('trainings')->group(function () {
        Route::get('/', [TrainingsController::class, 'list'])->name('trainings.list');
        Route::get('/create', [TrainingsController::class, 'create'])->name('trainings.create');
        Route::post('/store', [TrainingsController::class, 'store'])->name('trainings.store');
        Route::get('/edit/{training_id}', [TrainingsController::class, 'edit'])->name('trainings.edit');
        Route::post('/update/{training_id}', [TrainingsController::class, 'update'])->name('trainings.update');
        Route::get('/view/{training_id}', [TrainingsController::class, 'view'])->name('trainings.view');
        Route::get('/delete/{training_id}', [TrainingsController::class, 'delete'])->name('trainings.delete');
        Route::get('/addUser/{training_id}', [TrainingUserscontroller::class, 'addUsers'])->name('trainings.addUsers');
        Route::post('/addUser/store/{training_id}', [TrainingUserscontroller::class, 'storeUsers'])->name('trainings.storeUsers');
    });

    // Formers
    Route::prefix('formers')->group(function () {
        Route::get('/', [FormersController::class, 'list'])->name('formers.list');
        Route::get('/create', [FormersController::class, 'create'])->name('formers.create');
        Route::post('/store', [FormersController::class, 'store'])->name('formers.store');
        Route::get('/edit/{former_id}', [FormersController::class, 'edit'])->name('formers.edit');
        Route::get('/delete/{former_id}', [FormersController::class, 'delete'])->name('formers.delete');
        Route::get('/view/{former_id}', [FormersController::class, 'view'])->name('formers.view');
    });
});

// Auth routes - provided by Breeze
require __DIR__.'/auth.php';
