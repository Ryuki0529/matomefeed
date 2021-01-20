<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte;

class testCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test_code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '各種コードのテストに使用';

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
        //$crawler = Goutte::request('GET', "http://blog.livedoor.jp/bluejay01-review/archives/57591979.html");
        //echo $crawler->filter(".article-body-inner img")->eq(0)->attr('src');
        echo config('app.url');
    }
}
