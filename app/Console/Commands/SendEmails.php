<?php

namespace App\Console\Commands;

use App\Mail\PostMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Post;
use Illuminate\Support\Carbon;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = Post::where("created_at", ">", Carbon::now()->subDay())->where("created_at", "<", Carbon::now())->get();
        $message = 'Yesterday post';
        Mail::to('sanjeev@gmail.com')->send(new PostMail($posts, $message));
    }
}
