<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data=array();
            foreach($this->collection as $collection)
            {
                $data[]=['title' => $collection->title, 'description' => $collection->description];
            }
            return $data;
    }
}
