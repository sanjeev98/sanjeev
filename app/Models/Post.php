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

    /**
     * Post has many relationship with image.
     *
     * @var string
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * User has many relationship with post.
     *
     * @var string
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
