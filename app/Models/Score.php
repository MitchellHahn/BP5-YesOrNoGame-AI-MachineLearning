<?php
//mode voor score

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Score extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'score';
    protected $fillable = [
        //table score
        'naam', 'score',
    ];





}
