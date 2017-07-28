<?php

namespace App\Repositories;

use App\Tree;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TreeRepository implements TreeInterface{

    public $tree;

    function __construct(Tree $tree)
    {
        $this->tree = $tree;
    }

    public function getAll()
    {
        $nodes =  Tree::orderBy('depth', 'asc')->get();

        return $nodes;
    }

    public function delete($id)
    {
        Tree::destroy($id);

    }

    public function findById($id)
    {
        return Tree::find($id);
    }

    public function findByPath($id)
    {
        return Tree::where('path','like', '%'.$id.'%')->orderBy('depth', 'asc')->get();
    }

    public function updateParentDepth($node)
    {
        $path = ($node->path) ? '/'.$node->id : $node->id.'/';

        if(!$node->path)
        {
            DB::select('update tree set path = "", depth = depth -1 where path ="'. $node->id .'"');
        }

        DB::select('UPDATE tree SET path = REPLACE(path, "'.$path.'", ""), depth = depth - 1 WHERE path LIKE "%'.$path.'%"');

    }

    public function create($attributes)
    {

        $node = Tree::create($attributes);

        return $node->id;

    }

    public function count()
    {

        return Tree::count();

    }
}