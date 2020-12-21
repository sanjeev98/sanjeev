<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['id', 'user_id', 'title', 'description', 'posted_by', 'created_at', 'posted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';
}
