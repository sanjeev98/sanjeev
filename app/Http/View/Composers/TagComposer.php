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

    function myPost($a,$b)
    {
        if ($a['count']==$b['count']) return 0;
        return ($a['count']>$b['count'])?-1:1;
    }

    public function compose(View $view)
    {
        $value = Cache::remember('tags',300, function () {
            $tag=Tag::all();
            $tag2=[];
            foreach($tag as $tag1)
            {
                $tag1['count'] = count($tag1->posts);
                $tag2[]=$tag1;
            }
            uasort($tag2,array($this,'myPost'));
            return $tag2;
        });
        $value1 = Cache::remember('post',300, function () {
            $post=Post::orderby('created_at','desc')->get();
            $post1=[];
            foreach($post as $post2)
            {
                $post2['time'] =$post2->created_at->diffForHumans ();
                $post1[]=$post2;
            }
            return $post1;
        });
        $k = Cache::remember('hello',400, function () {
            $post=Post::all();
            $post2=[];
            foreach($post as $post3)
            {
                $post3['tag']= DB::table('tags')->leftJoin('post_tag','tags.id','=','post_tag.tag_id')->select('tags.name')->where('post_tag.post_id','=',$post3->id)->get();
                $post3['date']=$post3->created_at->format('Y-m-d');
                $post2[]=$post3;
            }
            return $post2;

        });
        $chart = Cache::remember('chart1',400, function () {
           $user1= DB::table('posts')->select(\DB::raw("COUNT(*) as count"))
                ->whereYear('created_at','2020')
                ->groupBy(\DB::raw("Month(created_at)"))
                ->pluck('count');
            $user= DB::table('posts')->select(\DB::raw("Month(created_at) as month"))
                ->whereYear('created_at','2020')
                ->groupBy(\DB::raw("Month(created_at)"))
                ->pluck('month');
            $postmonth=array(0,0,0,0,0,0,0,0,0,0,0,0);
            foreach($user as $index=>$user2)
            {
                $postmonth[$user2]=$user1[$index];
            }
           return $postmonth;
        });
        $chart1 = Cache::remember('chart2',400, function () {
            $user1= DB::table('users')->select(\DB::raw("COUNT(*) as count"))
                ->whereYear('created_at','2020')
                ->groupBy(\DB::raw("Month(created_at)"))
                ->pluck('count');
            $user= DB::table('users')->select(\DB::raw("Month(created_at) as month"))
                ->whereYear('created_at','2020')
                ->groupBy(\DB::raw("Month(created_at)"))
                ->pluck('month');
            $usermonth=array(0,0,0,0,0,0,0,0,0,0,0,0);
            foreach($user as $index=>$user2)
            {
                $usermonth[$user2]=$user1[$index];
            }
            return $usermonth;
        });
        $view->with('tags4',$value)->with('pos',$value1)->with('tab',$k)->with('chart',$chart)->with('chart1',$chart1);
    }
}
