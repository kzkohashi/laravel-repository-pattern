<?php

namespace App\Repositories;

interface ItemRepository
{

    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @return mixed
     */
    public function getList();

}