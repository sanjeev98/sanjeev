<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $posts = array();
        foreach ($this->collection as $collection) {
            $posts[] = ['title' => $collection->title, 'description' => $collection->description];
        }
        return $posts;
    }
}
