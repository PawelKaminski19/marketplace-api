<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;

class AddTagsSeeder extends Seeder
{
    protected $tags = '';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('tags')->count() < 2) {
            factory(Tag::class, 100)->create();
        }
    }
}
