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

                @foreach($nodes as $key => $node)

                    <div class="flex-container" id="container-{{$key}}">

                        @foreach($node as $subnode)

                            <div class="flex-item" id="item-{{$subnode->id}}">{{ $subnode->id }}<button type="button" class="btn btn-danger margin-left-20 removeBtn" data-id="'.$row->id.'">Delete</button></div>

                        @endforeach

                    </div>

                @endforeach

            </div>
            <!-- Tree view block ends here -->

            <!-- Add new child block starts here -->
            <div class="col-lg-6 form-inline">

                <div id="ajaxResponse"></div>
                <label for="parent">Parent ID: </label>
                <input type="text" class="form-control" id="parent" placeholder="0">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                <button type="button" class="btn btn-primary" id="addBtn">Add New Child</button>

            </div>
            <!-- Add new child block ends here -->

        </div>

    </div>

</body>
</html>
