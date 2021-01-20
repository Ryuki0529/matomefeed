<?php

namespace App\Console\Commands;

use App\Library\MyFunc;
use Illuminate\Console\Command;
use App\Models\SiteList;

class SiteInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:site_insert {name} {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '対象サイト情報を登録する';

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
        $result = SiteList::create([
            'name' => $this->argument('name'),
            'url' => $this->argument('url')
        ]);
        return null;
    }
}
