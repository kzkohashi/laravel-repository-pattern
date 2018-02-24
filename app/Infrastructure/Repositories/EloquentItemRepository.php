<?php

namespace App\Infrastracture\Repositories;

use App\Repositories\ItemRepository;
use App\Models\Item;

class EloquentItemRepository implements  ItemRepository
{

    protected $item;

    /**
     * EloquentItemRepository constructor.
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function get($id)
    {
        return $this->item->find(1);
    }

    public function getList()
    {
        return $this->item->all();
    }
}