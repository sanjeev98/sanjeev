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

    function sortTag($a, $b)
    {
        if ($a['count'] == $b['count']) return 0;
        return ($a['count'] > $b['count']) ? -1 : 1;
    }

    public function compose(View $view)
    {
        $tags_count = Cache::remember('tags', 300, function () {
            $tags = Tag::all();
            $tags_count = [];
            foreach ($tags as $tag) {
                $tag['count'] = count($tag->posts);
                $tags_count[] = $tag;
            }
            uasort($tags_count, array($this, 'sortTag'));
            return $tags_count;
        });
        $posts_created = Cache::remember('posts', 300, function () {
            $posts = Post::orderby('created_at', 'desc')->get();
            $posts_created = [];
            foreach ($posts as $post) {
                $post['created'] = $post->created_at->diffForHumans();
                $posts_created[] = $post;
            }
            return $posts_created;
        });
        $posts_table = Cache::remember('posts_table', 300, function () {
            $posts = Post::with('tags')->get();
            $posts_table = [];
            foreach ($posts as $post) {
                $post['date'] = $post->created_at->format('Y-m-d');
                $post_table[] = $post;
            }
            return $posts_table;

        });
        $view->with('tags_count', $tags_count)->with('posts_created', $posts_created)->with('posts_table', $posts_table);
    }
}
