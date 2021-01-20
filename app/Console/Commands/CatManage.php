<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class CatManage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cat_insert {name} {cat_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'データベースへカテゴリーを登録する';

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
        if ( $this->argument('name') == 0 ) {
            foreach ( [
                'ニュース', 'ゲーム', 'アニメ', '趣味',
                '芸能', 'スポーツ', '生活', '海外', 'テック'
            ] as $cat ) {
                Category::create([
                    'name'=> $cat, 'parent'=> $this->argument('cat_id')
                ]);
            }
        }else {
            Category::create(
                ['name'=> $this->argument('name'), 'parent'=> $this->argument('cat_id')
            ]);
        }
        return null;
    }
}
