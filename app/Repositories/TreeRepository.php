<?php

namespace App\Repositories;

use App\Tree;
use Illuminate\Support\Facades\DB;

class TreeRepository implements TreeInterface{

    public $tree;

    function __construct(Tree $tree)
    {
        $this->tree = $tree;
    }

    public function getAll()
    {
        $nodes =  DB::select('SELECT node.name, (COUNT(parent.name) - 1) AS depth
                        FROM tree AS node,
                                tree AS parent
                        WHERE node.lft BETWEEN parent.lft AND parent.rgt
                        GROUP BY node.name
                        ORDER BY node.lft');

        return $nodes;
    }

    public function delete($node)
    {
        $left = $node->lft;
        $right = $node->rgt;

        Tree::where('lft',$left)->delete();

        DB::select('update tree set rgt = rgt - 1, lft = lft - 1 where lft between ? and ?', [$left, $right]);

        DB::select('update tree set lft = lft - 2 where lft > ?', [$right]);

        DB::select('update tree set rgt = rgt - 2 where rgt > ?', [$right]);

        return true;
    }

    public function findByName($name)
    {
        return Tree::where('name', $name)->first();
    }

    public function create($node)
    {
        DB::select('update tree set rgt = rgt + 2 where rgt > ?', [$node->rgt - 1]);

        DB::select('update tree set lft = lft + 2 where lft > ?', [$node->rgt - 1]);

        Tree::create(array('name' => str_random(12), 'lft' => $node->rgt, 'rgt' => $node->rgt+1 ));

        return true;
    }
}