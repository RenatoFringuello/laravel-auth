<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Faker\Factory;
use Bluemmb\Faker\PicsumPhotosProvider;
use Illuminate\Support\Str;


class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = Factory::create();
        $faker->addProvider(new PicsumPhotosProvider($faker));

        $projectsInDb = Project::all(['image'])->toArray();
        for ($i=0; $i<30; $i++) {
            $proj = new Project();
            $proj->title = $faker->unique()->realTextBetween(4, 20);
            $proj->user_id = User::inRandomOrder()->get('id')[0]->id;
            $proj->slug = Str::slug($proj->title.(count($projectsInDb)+1).$proj->user_id.rand(0,10200));
            $proj->content = $faker->realTextBetween(30, 200);
            do{
                $proj->image = $faker->imageUrl(640, 480, rand(1,3000));
            }while(in_array($proj->image, $projectsInDb));
            $projectsInDb[] = $proj->image;
            $proj->start_date = $faker->dateTimeBetween('1990-12-20');
            $proj->end_date = (rand(0,1)) ? $faker->dateTimeBetween($proj->start_date) : null;
            // dd($proj);
            $proj->save();
        }
    }
}
