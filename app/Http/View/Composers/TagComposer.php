<?php


namespace App\Http\View\Composers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

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

        $view->with('tags4',$value)->with('post',$value1);
    }
}
