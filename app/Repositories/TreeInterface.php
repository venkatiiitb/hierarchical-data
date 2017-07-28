<?php

namespace App\Repositories;


interface TreeInterface {

    public function getAll();

    public function create($node);

    public function findById($id);

    public function findByPath($id);

    public function delete($node);

    public function updateParentDepth($node);

    public function count();

}