<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Todo extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = ['title', 'description','image', 'is_completed'];

    public $sortable = ['id','title', 'description', 'is_completed'];
}
