<?php

namespace App\Repositories;


interface TreeInterface {

    public function getAll();

    public function create($node);

    public function findByName($name);

    public function delete($node);

    public function updateNodesWhileCreating($node);

    public function count();

}