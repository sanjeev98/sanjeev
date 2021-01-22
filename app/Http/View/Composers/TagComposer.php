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
    function myPost($a, $b)
    {
        if ($a['count'] == $b['count']) return 0;
        return ($a['count'] > $b['count']) ? -1 : 1;
    }

    public function compose(View $view)
    {
        $value = Cache::remember('tags', 300, function () {
            $tag = Tag::all();
            $tag2 = [];
            foreach ($tag as $tag1) {
                $tag1['count'] = count($tag1->posts);
                $tag2[] = $tag1;
            }
            uasort($tag2, array($this, 'myPost'));
            return $tag2;
        });
        $value1 = Cache::remember('post', 300, function () {
            $post = Post::orderby('created_at', 'desc')->get();
            $post1 = [];
            foreach ($post as $post2) {
                $post2['time'] = $post2->created_at->diffForHumans();
                $post1[] = $post2;
            }
            return $post1;
        });
        $k = Cache::remember('hello', 400, function () {
            $post = Post::all();
            $post2 = [];
            foreach ($post as $post3) {
                $post3['tag'] = DB::table('tags')->leftJoin('post_tag', 'tags.id', '=', 'post_tag.tag_id')->select('tags.name')->where('post_tag.post_id', '=', $post3->id)->get();
                $post3['date'] = $post3->created_at->format('Y-m-d');
                $post2[] = $post3;
            }
            return $post2;
        });
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
        $view->with('tags4', $value)->with('pos', $value1)->with('tab', $k)->with('posts_chart', $posts_chart)->with('users_chart', $users_chart)->with('users_graph', $users_graph)->with('posts_graph', $posts_graph);
    }
}
