<?php

//voor failed node
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedNode extends Model
{
    use HasFactory;

    protected $table = 'smart_guess_fail_nodes';
    protected $fillable = [
        //table smart_guess_fail_nodes
        'node', 'id', 'created_at'
    ];


}
