<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoMedia extends Model
{
    use HasFactory;
    public $table = 'todo_media';
    protected $fillable = [
        'toDoListId',
        'file',
    ];

}
