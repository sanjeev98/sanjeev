<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use APP\Models\Post;
use Illuminate\Support\Carbon;

class PostExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return Post::where("created_at",">",Carbon::now()->subDay())->where("created_at","<",Carbon::now())->get();
    }
}
