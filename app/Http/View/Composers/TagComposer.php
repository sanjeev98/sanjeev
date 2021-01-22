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
        $posts_chart = Cache::remember('posts_chart', 1, function () {
            $postsCreatedAt = DB::table('posts')->select([\DB::raw("COUNT(*) as count"), \DB::raw("Month(created_at) as month")])
                ->whereYear('created_at', '=', Carbon::now()->subYear()->year)
                ->groupBy(\DB::raw("Month(created_at)"))
                ->orderBy(\DB::raw("Month(created_at)"))->get();
            $post_month = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            foreach ($postsCreatedAt as $postCreatedAt) {
                $post_month[$postCreatedAt->month - 1] = $postCreatedAt->count;
            }
            return $post_month;
        });
        $users_chart = Cache::remember('users_chart', 1, function () {
            $usersCreatedAt = DB::table('users')->select([\DB::raw("COUNT(*) as count"), \DB::raw("Month(created_at) as month")])
                ->whereYear('created_at', Carbon::now()->subYear()->year)
                ->groupBy(\DB::raw("Month(created_at)"))
                ->orderBy(\DB::raw("Month(created_at)"))->get();
            $user_month = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            foreach ($usersCreatedAt as $userCreatedAt) {
                $user_month[$userCreatedAt->month - 1] = $userCreatedAt->count;
            }
            return $user_month;
        });
        $users_graph = Cache::remember('users_graph', 1, function () {
            $year = Carbon::now()->subYear()->year;
            $usersCreatedAt = DB::table('users')->select([\DB::raw("COUNT(*) as count"), \DB::raw("Year(created_at) as year")])
                ->whereBetween(\DB::raw("Year(created_at)"), [$year - 10, $year])
                ->groupBy(\DB::raw("Year(created_at)"))
                ->orderBy(\DB::raw("Year(created_at)"))->get();
            $user_year = array();
            $year = $year - 10;
            foreach ($usersCreatedAt as $userCreatedAt) {
                if ($userCreatedAt->year == $year)
                    $users_year[] = $userCreatedAt->count;
                else
                    $user_year[] = 0;
                ++$year;
            }
            return $user_year;
        });
        $posts_graph = Cache::remember('posts_graph', 1, function () {
            $year = Carbon::now()->subYear()->year;
            $postsCreatedAt = DB::table('posts')->select([\DB::raw("COUNT(*) as count"), \DB::raw("Year(created_at) as year")])
                ->whereBetween(\DB::raw("Year(created_at)"), [$year - 10, $year])
                ->groupBy(\DB::raw("Year(created_at)"))
                ->orderBy(\DB::raw("Year(created_at)"))->get();
            $post_year = array();
            $year = $year - 10;
            foreach ($postsCreatedAt as $postCreatedAt) {
                if ($postCreatedAt->year == $year)
                    $post_year[] = $postCreatedAt->count;
                else
                    $post_year[] = 0;
                ++$year;
            }
            return $post_year;
        });
        $view->with('latest_tag', $latest_tag)->with('posts_table', $posts_table)->with('latest_post', $latest_post);->with('posts_chart', $posts_chart)->with('users_chart', $users_chart)->with('users_graph', $users_graph)->with('posts_graph', $posts_graph);
    }
}
