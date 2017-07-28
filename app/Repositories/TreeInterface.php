<?php

namespace App\Repositories;


interface TreeInterface {

    public function getAll();

    public function create($node);

    public function findById($id);

    public function delete($node);

    public function updateNodesWhileCreating($node);

    public function count();

}