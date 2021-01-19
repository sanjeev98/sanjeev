<?php

namespace App\Http\View\Composers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;

class TagComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $latest_tag = Cache::remember('tags', 300, function () {
            $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->limit(5)->get();
            return $tags;
        });
        $posts_table = Cache::remember('posts', 300, function () {
            $posts = Post::with('tags')->latest()->get();
            return $posts;
        });
        $latest_post = $posts_table->slice(0, 5);
        $view->with('latest_tag', $latest_tag)->with('posts_table', $posts_table)->with('latest_post', $latest_post);
    }
}
