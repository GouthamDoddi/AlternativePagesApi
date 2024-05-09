<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the default state for the model's attributes.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->slug,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            // Add more default attributes here if needed
        ];
    }

    /**
     * Define a state with custom attributes.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withParentId($parentId)
    {
        return $this->state(function (array $attributes) use ($parentId) {
            return [
                'parent_id' => $parentId,
            ];
        });
    }
}
