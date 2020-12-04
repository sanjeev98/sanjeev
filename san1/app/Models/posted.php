<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posted extends Model
{
    use HasFactory;
    protected $table="posteds";
    protected $fillable = [
       'id','title','user_id', 'description','posted_by','created_at','updated_at'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
