<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['comment', 'post_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coments';

    /**
     *posts has many comments.
     *
     * @var string
     */
    public function posts()
    {
        return $this->belongsTo(Post::class);
    }
}
