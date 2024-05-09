<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Page;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method.
     *
     * @return void
     */
    public function testIndex()
    {
        // Create some dummy pages
        Page::factory()->count(3)->create();

        // Hit the index endpoint
        $response = $this->get('/api/pages');

        // Assert response is successful
        $response->assertStatus(200)
            ->assertJsonCount(3, 'pages');
    }

    /**
     * Test store method.
     *
     * @return void
     */
    public function testStore()
    {
        // Data for creating a page
        $data = [
            'slug' => 'test-page',
            'title' => 'Test Page',
            'content' => 'Lorem ipsum dolor sit amet',
        ];

        // Hit the store endpoint with data
        $response = $this->postJson('/api/pages', $data);

        // Assert response is successful and contains created page
        $response->assertStatus(201)
            ->assertJsonFragment($data);

        // Assert page exists in database
        $this->assertDatabaseHas('pages', $data);
    }

    /**
     * Test show method.
     *
     * @return void
     */
    public function testShow()
    {
        // Create a dummy page
        $page = Page::factory()->create();



        // Hit the show endpoint with the page's ID
        $response = $this->get('/api/pages/' . $page->id);

        // Assert response is successful and contains the page
        $response->assertStatus(200)
            ->assertJsonFragment($page->toArray());
    }

    /**
     * Test update method.
     *
     * @return void
     */
    public function testUpdate()
    {
        // Create a dummy page
        $page = Page::factory()->create();

        // Updated data for the page
        $updatedData = [
            'slug' => 'updated-page',
            'title' => 'Updated Page',
            'content' => 'Updated content',
        ];

        // Hit the update endpoint with updated data
        $response = $this->putJson('/api/pages/' . $page->id, $updatedData);

        // Assert response is successful
        $response->assertStatus(200);

        // Assert page in database is updated
        $this->assertDatabaseHas('pages', $updatedData);
    }

    /**
     * Test destroy method.
     *
     * @return void
     */
    public function testDestroy()
    {
        // Create a dummy page
        $page = Page::factory()->create();

        // Hit the destroy endpoint with the page's ID
        $response = $this->delete('/api/pages/' . $page->id);

        // Assert response is successful
        $response->assertStatus(200);

        // Assert page is deleted from database
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }
}
