<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    protected $faker;
    public function __construct(Faker $factory)
    {
        $this->faker=Faker::create('App\Models\Comment');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops =[
            [
                'name' =>$this->faker->name(),
                'text' => $this->faker->sentence(),
                'children' => [
                    [
                        'name' =>$this->faker->name(),
                        'text' => $this->faker->sentence(),
                        'children' => [
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                        ],
                    ],
                    [
                        'name' =>$this->faker->name(),
                        'text' => $this->faker->sentence(),
                        'children' => [
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' =>$this->faker->name(),
                'text' => $this->faker->sentence(),
                'children' => [
                    [
                        'name' =>$this->faker->name(),
                        'text' => $this->faker->sentence(),
                        'children' => [
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                        ],
                    ],
                    [
                        'name' =>$this->faker->name(),
                        'text' => $this->faker->sentence(),
                        'children' => [
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                            [
                                'name' =>$this->faker->name(),
                                'text' => $this->faker->sentence(),
                            ],
                        ],
                    ],
                ],
            ]
        ];

        foreach($shops as $shop)
        {
            Comment::create($shop);
        }
    }
}
