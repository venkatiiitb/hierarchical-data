$(document).ready(function() {

    /**
     * handles add a new child event
     */
    $('#addBtn').on('click', function (e) {

        e.preventDefault();

        var parent = $('#parent').val();
        var token  = $('#token').val();

        if(parent)
        {

            $.ajax({
                type: "POST",
                url: '/add',
                data: {parent:parent,_token:token},
                success: function( response ) {

                    if(response.status === 200)
                    {
                        $('#ajaxResponse').html('<strong>Success!</strong> '+ response.message).addClass('alert alert-success');

                        $('#parent').val('');

                        $('#container-'+response.depth).append('<div class="flex-item" id="item-'+response.id+'">ID: '+response.id+'['+response.depth+']<button type="button" class="btn btn-danger margin-left-20 removeBtn" data-id="'+response.id+'" data-depth="'+response.depth+'" data-path="'+response.path+'">Delete</button></div>')

                        if(!$('#container-'+response.depth).next('.flex-container').length)
                        {

                            var depth = parseInt(response.depth)+1;

                            $('#container-'+response.depth).parent().append('<div class="flex-container" id="container-'+depth+'"></div>');

                        }

                    }else{

                        $('#ajaxResponse').html('<strong>Error!</strong> '+ response.message).addClass('alert alert-error');

                    }

                }

            });

        }else{

            $('#ajaxResponse').html('<strong>Error!</strong> Please enter a valid parent ID!').addClass('alert alert-error');

        }

        setTimeout(function(){ $("#ajaxResponse").html("").attr('class','') }, 5000);

    });

    /**
     * handles remove a node event
     */
    $('body').on('click', '.removeBtn', function (e) {

        e.preventDefault();

        var id = $(this).attr('data-id');
        var depth = $(this).attr('data-depth');
        var path = $(this).attr('data-path');
        var token  = $('#token').val();

        if(parent)
        {

            $.ajax({
                type: "POST",
                url: '/delete',
                data: {id:id,_token:token},
                success: function( response ) {

                    if(response.status === 200)
                    {

                        if($('#container-'+ depth).children.length === 1)
                        {

                            var newDepth = parseInt(depth)+1;

                            $('#container-'+newDepth).remove();

                            $('#item-'+id).remove();

                        }else{

                            $('#item-'+id).remove();

                        }

                        response.nodes.forEach(function(node){

                            if($('#container-'+ node.depth).children.length === 1)
                            {

                                var containerDepth = parseInt(node.depth)+1;

                                $('#container-'+containerDepth).remove();

                                $('#item-'+node.id).remove();

                            }else{

                                $('#item-'+node.id).remove();

                            }

                            var itemDepth = parseInt(node.depth) - 1;

                            var searchPath = (path) ? '/'+id : id+'/';

                            var newPath = node.path.replace(searchPath, "");

                            if(!path && node.path === id)
                            {
                                newPath = "";
                            }

                            $('#container-'+itemDepth).append('<div class="flex-item" id="item-'+node.id+'">ID: '+node.id+'['+itemDepth+']<button type="button" class="btn btn-danger margin-left-20 removeBtn" data-id="'+node.id+'" data-depth="'+itemDepth+'" data-path="'+newPath+'">Delete</button></div>');

                        });

                        $('#ajaxResponse').html('<strong>Success!</strong> '+ response.message).addClass('alert alert-success');

                    }else{

                        $('#ajaxResponse').html('<strong>Error!</strong> '+ response.message).addClass('alert alert-error');

                    }

                }

            });

        }else{

            $('#ajaxResponse').html('<strong>Error!</strong> Please enter a valid parent ID!').addClass('alert alert-error');

        }

        setTimeout(function(){ $("#ajaxResponse").html("").attr('class','') }, 5000);

    });

});