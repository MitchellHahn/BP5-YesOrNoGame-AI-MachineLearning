<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'node_relation';
    protected $fillable = [
        //table node_relation
        'node_yes', 'node_no', 'parent_node', 'id',
    ];


// eloquent relatie voor node
    public function node()
    {
        return $this->belongsTo(node::class );
    }

    // eloquent relatie voor  ja node
    public function yes()
    {
        return $this->belongsTo(node::class, 'node_yes');
    }

    // eloquent relatie voor nee node

    public function no()
    {
        return $this->belongsTo(node::class, 'node_no');
    }
}
