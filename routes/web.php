<?php

use App\Http\Controllers\ToDoListController;
use Illuminate\Support\Facades\Route;

Route::post('todo/media', [ToDoListController::class, 'storeMedia'])->name('todo.storeMedia');
Route::get('/', [ToDoListController::class, 'index'])->name('todo.index');
Route::post('/delete-file', [ToDoListController::class, 'deleteFile'])->name('todo.deleteFile');

Route::get('/api/todo-list', [ToDoListController::class, 'api'])->name('api.todolist');
Route::get('/fetch-api/todo-list', [ToDoListController::class, 'fetchApi'])->name('api.todolist');


Route::resource('todo', ToDoListController::class);