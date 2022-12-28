<?php

use App\Http\Controllers\API\AboutController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EducationController;
use App\Http\Controllers\API\ExperiencesController;
use App\Http\Controllers\API\MessagesController;
use App\Http\Controllers\API\ProjectsController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\SkillsController;
use App\Http\Controllers\API\TestimonialsController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register','App\Http\Controllers\API\AuthController@register');
Route::post('/login','App\Http\Controllers\API\AuthController@login');*/


Route::controller(AuthController::class)->group(function (){
    Route::post('login','login');
    Route::post('register','register');
});

Route::controller(AboutController::class)->group(function (){
    Route::get('edit_about','edit_about');
    Route::post('/update_about/{id}','update_about');
});

Route::controller(ServiceController::class)->group(function (){
    Route::get('get_all_service','get_all_service');
    Route::post('create_service','create_service');
    Route::post('update_service/{id}','update_service');
    Route::get('delete_service/{id}','delete_service');
});

Route::controller(SkillsController::class)->group(function (){
    Route::get('get_all_skills','get_all_skills');
    Route::post('create_skill','create_skill');
    Route::post('update_skill/{id}','update_skill');
    Route::get('delete_skill/{id}','delete_skill');
});
Route::controller(EducationController::class)->group(function (){
    Route::get('get_all_educations','get_all_educations');
    Route::post('create_education','create_education');
    Route::post('update_education/{id}','update_education');
    Route::get('delete_education/{id}','delete_education');

});

Route::controller(ExperiencesController::class)->group(function (){
    Route::get('get_all_experiences','get_all_experiences');
    Route::post('create_experience','create_experience');
    Route::post('update_experience/{id}','update_experience');
    Route::get('delete_experience/{id}','delete_experience');

});

Route::controller(ProjectsController::class)->group(function (){
    Route::get('get_all_project','get_all_project');
    Route::post('add_project','add_project');
    Route::post('update_project/{id}','update_project');
    Route::get('get_edit_project/{id}','get_edit_project');
    Route::get('delete_project/{id}','delete_project');

});

Route::controller(TestimonialsController::class)->group(function (){
    Route::get('get_all_testimonial','get_all_testimonial');
    Route::get('get_testimonial/{id}','get_testimonial');
    Route::get('delete_testimonial/{id}','delete_testimonial');
    Route::post('add_testimonial','add_testimonial');
    Route::post('update_testimonial/{id}','update_testimonial');

});

Route::controller(MessagesController::class)->group(function (){
    Route::get('get_all_message','get_all_message');
    Route::get('delete_message/{id}','delete_message');
    Route::post('update_status/{id}','update_status');

});

Route::controller(UsersController::class)->group(function (){
    Route::get('get_all_user','get_all_user');
    Route::post('create_user','create_user');
    Route::post('update_user/{id}','update_user');
    Route::get('delete_user/{id}','delete_user');
    Route::get('profile','profile');
    Route::post('update_profile/{id}','update_profile');
    Route::get('user','user');
});
