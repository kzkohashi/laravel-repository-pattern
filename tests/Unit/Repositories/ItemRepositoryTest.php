<?php

namespace Tests\Unit\Repositories;

use App\Repositories\ItemRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    protected $repo;

    public function setUp()
    {
        parent::setUp();
        $this->repo = $this->app->make(ItemRepository::class);
    }

    /**
     * @test
     */
    public function it_can_find_item_id()
    {

        $item = factory(\App\Models\Item::class)->create([
            'id' => 1,
            'name' => 'item_id_1'
        ]);

        $result = $this->repo->get(1);

        $this->assertSame($result->name, 'item_id_1');

    }
}
