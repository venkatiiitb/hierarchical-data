<?php

namespace App\Http\Controllers;

use App\Repositories\TreeInterface as TreeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class TreeManagerController extends Controller
{

    public function __construct(TreeInterface $tree)
    {
        $this->tree = $tree;
    }

    /**
     * Display a nodes of tree.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $nodes = $this->tree->getAll();

        if($request->ajax()){

            if(count($nodes) === 0)
            {

                return Response::json(['status' => 500,'message' => 'There were no nodes in the tree']);

            }

            return Response::json(['status' => 200,'data' => $nodes]);

        }

        $temp_nodes = [];

        if (count($nodes) > 0) {

            foreach ($nodes as $key => $row) {

                $temp_nodes[$row->depth][] = $row;

            }

        }

        return view('tree')->with(array('nodes' => $temp_nodes));

    }

    /**
     * Adds a new node to the tree view
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function addNode(Request $request)
    {

        try
        {

            $parent = $request->input('parent');

            $node = $this->tree->findById($parent);

            if($node)
            {
                $response = DB::transaction(function () use($node) {

                    $this->tree->updateNodesWhileCreating($node);

                    $attributes = array('lft' => $node->rgt, 'rgt' => $node->rgt+1 );

                    $this->tree->create($attributes);

                    return ['status' => 200,'message' => 'Node added successfully!'];

                });

                Log::info(json_encode($response));

                return Response::json($response);

            }else{

                $nodes = $this->tree->count();

                if($nodes > 0)
                {

                    Log::error(json_encode(['status' => 402,'message' => 'Please enter a valid parent ID']));

                    return Response::json(['status' => 402,'message' => 'Please enter a valid parent ID']);

                }

                $attributes = array('lft' => 1, 'rgt' => 2 );

                $this->tree->create($attributes);

                Log::info(json_encode(['status' => 200,'message' => 'Node added successfully!']));

                return Response::json(['status' => 200,'message' => 'Node added successfully!']);

            }

        }catch (Exception $e) {

            Log::error('Exception occurred while adding a new child to the tree!');

        }

    }

    /**
     * Gets all the nodes
     *
     * @return array of nodes
     */
    public function getNodes()
    {

        return $this->tree->getAll();

    }

    /**
     * Display a nodes of tree.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function deleteNode(Request $request)
    {

        try
        {

            $id = $request->input('id');

            $node = $this->tree->findById($id);

            if($node)
            {

                $response = DB::transaction(function () use($node) {

                    $this->tree->delete($node);

                    return ['status' => 200,'message' => 'Node deleted successfully!'];

                });

                Log::info(json_encode($response));

                return Response::json($response);

            }else{

                Log::error(json_encode(['status' => 402,'message' => 'Invalid Node!']));

                return Response::json(['status' => 402,'message' => 'Invalid Node!']);

            }

        }catch (Exception $e) {

            Log::error('Exception occurred while deleting a child to the tree!');

        }

    }

}
