<?php

namespace App\Models;
//model voor node
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class node extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'node';
    protected $fillable = [
        //table node
        'question', 'answer', "id"
    ];


// 1 node is gekopeld aan 1 parent node
    public function relation()
    {
         return $this->hasOne(relation::class, 'parent_node');
    }



}
