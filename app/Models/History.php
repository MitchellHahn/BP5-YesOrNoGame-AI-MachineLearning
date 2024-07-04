<?php
//voor geschiedenis
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class History extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'node_history';
    protected $fillable = [
        //table node_history
        'datum', 'node', 'id', 'parent_node',
    ];

        public function node()
        {
            return $this->belongsTo(node::class, 'node' );
        }



}
