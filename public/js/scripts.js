$(document).ready(function() {

    /**
     * styles the tree view with animations
     */
    styleTree();

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

                        rebuildTree();

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
                        $('#ajaxResponse').html('<strong>Success!</strong> '+ response.message).addClass('alert alert-success');

                        rebuildTree();

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

/**
 * re builds entire tree
 */
function rebuildTree()
{

    $.ajax({
        type: "GET",
        url: '/',
        success: function( response ) {

            if(response.status === 200)
            {

                var nodes  = response.data;

                var html = '';
                var depth = -1;
                var flag = false;

                nodes.forEach(function(node){

                    while (node.depth > depth) {

                        html +="<ul><li><a href='javascript:void(0);'>";
                        flag = false;
                        depth++;

                    }

                    while (node.depth < depth) {

                        html += "</a></li></ul>";
                        depth--;

                    }

                    if (flag) {

                        html += "</a></li><li><a href='javascript:void(0);'>";
                        flag = false;

                    }

                    html += node.id +'<button type="button" class="btn btn-danger margin-left-20 removeBtn" data-id="'+node.id+'">Delete</button>';
                    flag = true;

                });

                while (depth-- > -1) {

                    html += "</a></li></ul>";

                }

                $('#tree_view').html(html);

                styleTree();

            }else{

                $('#tree_view').html('<div class="alert alert-warning"><strong>Warning!</strong> '+ response.message+'</div>');

            }

        }

    });

}

/**
 * styles the tree with animations
 */
function styleTree()
{
    // Select the main list and add the class "hasSubmenu" in each LI that contains an UL
    $('ul').each(function(){

        $this = $(this);

        $this.find("li").has("ul").addClass("hasSubmenu");

    });

    // Find the last li in each level
    $('li:last-child').each(function(){

        $this = $(this);

        // Check if LI has children
        if ($this.children('ul').length === 0){

            // Add border-left in every UL where the last LI has not children
            $this.closest('ul').css("border-left", "1px solid gray");

        } else {

            // Add border in child LI, except in the last one
            $this.closest('ul').children("li").not(":last").css("border-left","1px solid gray");

            // Add the class "addBorderBefore" to create the pseudo-element :defore in the last li
            $this.closest('ul').children("li").last().children("a").addClass("addBorderBefore");

            // Add margin in the first level of the list
            $this.closest('ul').css("margin-top","20px");

            // Add margin in other levels of the list
            $this.closest('ul').find("li").children("ul").css("margin-top","20px");

        };

    });

    // Add bold in li and levels above
    $('ul li').each(function(){

        $this = $(this);

        $this.mouseenter(function(){

            $( this ).children("a").css({"font-weight":"bold","color":"#336b9b"});

        });

        $this.mouseleave(function(){

            $( this ).children("a").css({"font-weight":"normal","color":"#428bca"});

        });

    });

    // Add button to expand and condense - Using FontAwesome
    $('ul li.hasSubmenu').each(function(){

        $this = $(this);

        $this.prepend("<a href='#'><i class='fa fa-minus-circle' aria-hidden='true'></i><i style='display:none;' class='fa fa-plus-circle' aria-hidden='true'></i></a>");

        $this.children("a").not(":last").removeClass().addClass("toogle");

    });

    // Actions to expand and consense
    $('ul li.hasSubmenu a.toogle').click(function(){

        $this = $(this);

        $this.closest("li").children("ul").toggle("slow");

        $this.children("i").toggle();

        return false;

    });

}