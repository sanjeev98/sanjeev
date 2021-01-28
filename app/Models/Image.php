<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'post_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     *posts has many image.
     *
     * @var string
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
