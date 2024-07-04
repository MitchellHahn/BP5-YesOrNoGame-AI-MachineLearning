<?php
//mode voor success node

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessNode extends Model
{
    use HasFactory;

    protected $table = 'smart_guess_success_nodes';
    protected $fillable = [
        //table smart_guess_success_nodes
        'node', 'id', 'created_at'
    ];



}
