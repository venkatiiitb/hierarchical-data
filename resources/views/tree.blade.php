<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tree Manager</title>

    <!-- styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

    <!-- scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>

</head>
<body>

    <div class="container">

        <div class="row margin-50">

            <!-- Tree view block starts here -->
            <div class="col-lg-6" id="tree_view">

                <?php

                    if(count($nodes) > 0)
                    {

                        $depth = -1;
                        $flag = false;
                        foreach ($nodes as $row) {
                            while ($row->depth > $depth) {
                                echo "<ul><li><a href='javascript:void(0);'>";
                                $flag = false;
                                $depth++;
                            }
                            while ($row->depth < $depth) {
                                echo "</a></li></ul>";
                                $depth--;
                            }
                            if ($flag) {
                                echo "</a></li><li><a href='javascript:void(0);'>";
                                $flag = false;
                            }
                            echo $row->name.'<button type="button" class="btn btn-danger margin-left-20 removeBtn" data-name="'.$row->name.'">Delete</button>' ;
                            $flag = true;
                        }

                        while ($depth-- > -1) {
                            echo "</a></li></ul>";
                        }

                    }else{

                        echo '<div class="alert alert-warning"><strong>Warning!</strong> There were no nodes in the tree!</div>';

                    }


                ?>

            </div>
            <!-- Tree view block ends here -->

            <!-- Add new child block starts here -->
            <div class="col-lg-6 form-inline">

                <div id="ajaxResponse"></div>
                <label for="parent">Parent ID: </label>
                <input type="text" class="form-control" id="parent" placeholder="25604">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                <button type="button" class="btn btn-primary" id="addBtn">Add New Child</button>

            </div>
            <!-- Add new child block ends here -->

        </div>

    </div>

</body>
</html>
