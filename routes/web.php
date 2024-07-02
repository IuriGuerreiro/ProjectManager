<?php

use App\Http\Controllers\GreetingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ProjectusersController;
use App\Http\Controllers\TasksusersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamProjectController;
use App\Http\Controllers\TrainingsController;
use App\Http\Controllers\FormersController;
use App\Http\Controllers\TrainingUserscontroller;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard']) -> name('dashboard');

Route::get('/Project', [ProjectController::class, 'index']) -> name('projects.list');
Route::get('/Project/edit/{id}', [ProjectController::class, 'edit']) -> name('projects.edit');
Route::get('/Project/view/{id}', [ProjectController::class, 'view']) -> name('projects.view');
Route::get('/Project/delete/{id}', [ProjectController::class, 'delete']) -> name('projects.delete');
Route::get('/Project/create', [ProjectController::class, 'create']) -> name('projects.create');
Route::post('/Project/store', [ProjectController::class, 'store']) -> name('projects.store');
Route::post('/Project/update/{id}', [ProjectController::class, 'update']) -> name('projects.update');







Route::get('/task', [TaskController::class, 'index']) -> name('tasks.list');
Route::get('/task/delete/{id}', [TaskController::class, 'delete']) -> name('tasks.delete');
Route::get('/task/create', [TaskController::class, 'create']) -> name('tasks.create');
Route::get('/task/listProject/{project_id}', [TaskController::class, 'listByProject']) -> name('tasks.listbyProject');
Route::post('/task/store', [TaskController::class, 'store']) -> name('tasks.store');
Route::get('/task/edit/{id}', [TaskController::class, 'edit']) -> name('tasks.edit');
Route::post('/task/update/{id}', [TaskController::class, 'update']) -> name('tasks.update');
Route::get('/task/view/{id}', [TaskController::class, 'view']) -> name('tasks.view');







Route::get('/users', [userController::class, 'index']) -> name('users.list');
Route::get('/users/delete/{id}', [userController::class, 'delete']) -> name('users.delete');
Route::get('/users/create', [userController::class, 'create']) -> name('users.create');
Route::get('/users/listProject/{project_id}', [TaskController::class, 'listByProject']) -> name('users.listbyProject');
Route::post('/users/store', [userController::class, 'store']) -> name('users.store');
Route::get('/users/edit/{id}', [userController::class, 'edit']) -> name('users.edit');
Route::post('/users/update/{id}', [userController::class, 'update']) -> name('users.update');
Route::get('/users/view/{id}', [userController::class, 'view']) -> name('users.view');

Route::get('/users/AdduserToTask/{project_id}', [TasksusersController::class, 'AddToTask']) -> name('users.AddToTask');
Route::post('/users/AddTaskTouser/Store/{project_id}', [TasksusersController::class, 'store']) -> name('users.storeToTasks');

Route::get('/users/removeTaskTouser/{id}', [TasksusersController::class, 'remove']) -> name('users.removeFromTask');
Route::get('/users/removeuserToTask/{id}', [TasksusersController::class, 'remove']) -> name('users.removeuserToTask');

Route::get('/users/addrole{user_id}', [RoleController::class, 'addRole']) -> name('users.addRole');
Route::post('/users/addrole/store/{user_id}', [RoleController::class, 'storeRole']) -> name('users.storeRole');
Route::get('/users/removeRole/{id}', [RoleController::class, 'removeRole']) -> name('users.removeRole');






Route::get('/teams', [TeamController::class, 'index']) -> name('teams.list');
Route::get('/teams/delete/{team_id}', [TeamController::class, 'delete']) -> name('teams.delete');
Route::get('/teams/create', [TeamController::class, 'create']) -> name('teams.create');
Route::post('/teams/store', [TeamController::class, 'store']) -> name('teams.store');
Route::get('/teams/view/{team_id}', [TeamController::class, 'view']) -> name('teams.view');
Route::get('/teams/edit/{team_id}', [TeamController::class, 'edit']) -> name('teams.edit');
Route::get('/teams/addUser/{user_id}', [TeamController::class, 'AddUser']) -> name('teams.AddUser');
Route::post('/teams/addUser/store/{team_id}', [TeamController::class, 'storeUser']) -> name('teams.storeUser');
Route::get('/teams/removeUser/{user_id}', [TeamController::class, 'removerUser']) -> name('teams.removerUser');
Route::post('/teams/update/{team_id}', [TeamController::class, 'update']) -> name('teams.update');

Route::get('/teams/AdduserToTeam/{team_id}', [TeamController::class, 'AddToTeam']) -> name('teams.AddToTeam');
Route::post('/teams/AddTeamTouser/Store/{team_id}', [TeamController::class, 'store']) -> name('teams.storeToTeam');

Route::get('/teams/AddProjectToTeam/{project_id}', [TeamProjectController::class, 'AddProjectToTeam']) -> name('teams.AddProjectToTeam');
Route::post('/teams/AddProjectToTeam/Store/{project_id}', [TeamProjectController::class, 'storeProjectToTeam'])->name('teams.storeProjectToTeam');

Route::get('/teams/AdduserToProject/{team_id}', [TeamProjectController::class, 'addTeamToProject']) -> name('teams.addTeamToProject');
Route::post('/teams/AdduserToProject/store/{user_id}', [TeamProjectController::class, 'storeTeamToProject']) -> name('teams.storeTeamToProject');
Route::get('/teams/TeamFromProject/{Teams_project_id}', [TeamProjectController::class, 'remove']) -> name('teams.removeProject');








Route::get('/trainings', [TrainingsController::class, 'list']) -> name('trainings.list');
Route::get('/trainings/create', [TrainingsController::class, 'create']) -> name('trainings.create');
Route::post('/trainings/store', [TrainingsController::class, 'store']) -> name('trainings.store');
Route::get('/trainings/edit/{training_id}', [TrainingsController::class, 'edit']) -> name('trainings.edit');
Route::post('/trainings/update/{training_id}', [TrainingsController::class, 'update']) -> name('trainings.update');
Route::get('/trainings/delete/{training_id}', [TrainingsController::class, 'delete']) -> name('trainings.delete');
Route::get('/trainings/view/{training_id}', [TrainingsController::class, 'view']) -> name('trainings.view');

Route::get('/trainings/addUser/{training_id}', [TrainingUserscontroller::class, 'addUsers']) -> name('trainings.addUsers');
Route::post('/trainings/addUser/store/{training_id}', [TrainingUserscontroller::class, 'storeUsers']) -> name('trainings.storeUsers');





Route::get('/formers', [FormersController::class, 'list']) -> name('formers.list');
Route::get('/formers/create', [FormersController::class, 'create']) -> name('formers.create');
Route::post('/formers/store', [FormersController::class, 'store']) -> name('formers.store');
Route::get('/formers/edit/{former_id}', [FormersController::class, 'edit']) -> name('formers.edit');
Route::get('/formers/delete/{former_id}', [FormersController::class, 'delete']) -> name('formers.delete');
Route::get('/formers/view/{former_id}', [FormersController::class, 'view']) -> name('formers.view');