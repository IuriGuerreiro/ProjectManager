<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('trainings_users', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        schema::table('formers', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        schema::table('training_formers', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('task_users', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('teams_projects', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        Schema::table('teams_users', function (Blueprint $table) {
            $table->SoftDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('trainings_users', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        schema::table('formers', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        schema::table('training_formers', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('task_users', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('projects', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('teams', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('teams_projects', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
        Schema::table('teams_users', function (Blueprint $table) {
            $table-> dropSoftDeletes();
        });
    }
};
