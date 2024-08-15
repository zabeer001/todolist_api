<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
    use HasFactory;
    public $table = 'to_do_lists';

    protected $fillable = [
        'date',
        'time',
        'title',
        'description'
    ];


    public function todoMedia()
    {
        return $this->hasMany(TodoMedia::class, 'toDoListId', 'id');
    }
}
