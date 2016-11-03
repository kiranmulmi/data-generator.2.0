<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Generator - Home</title>

    <link href="/resources/css/bootstrap.min.css" rel="stylesheet">
    <link href="/resources/css/styles.css" rel="stylesheet">

    <!--Icons-->
    <script src="/resources/js/lumino.glyphs.js"></script>

    <!--[if lt IE 9]>
    <script src="/resources/js/html5shiv.js"></script>
    <script src="/resources/js/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><span>Data</span>Generator v2.0</a>
        </div>

    </div><!-- /.container-fluid -->
</nav>


<div class="col-sm-9 col-sm-offset-2 col-lg-10 col-lg-offset-1 main">
    <?php if(isset($_SESSION["msg"])) { ?>
        <div class="row">
            <div class="alert bg-success alert-dismissible" role="alert">
                <svg class="glyph stroked checkmark">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-checkmark"></use></svg><?php echo $_SESSION["msg"] ?> <a href="" class="pull-right" data-dismiss="alert"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
        </div>
        <?php unset($_SESSION["msg"]) ?>
    <?php } ?>

    <!--<div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li class="active">Home</li>
        </ol>
    </div>--><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Connection to database server</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Connection details
                    <button class="btn btn-success pull-right" data-toggle="modal" data-target="#addNewConnection">Add
                        New Connection
                    </button>
                </div>
                <div class="panel-body">
                    <?php $i = 1; ?>
                    <table class="table table-bordered fixed-table-container">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Server</th>
                            <th>User</th>
                            <th>Password</th>
                            <th>Port</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($Connection as $row) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row['server_description'] ?></td>
                                <td><?php echo $row['server'] ?></td>
                                <td><?php echo $row['user'] ?></td>
                                <td>*****</td>
                                <td><?php echo $row['port'] ?></td>
                                <td style="min-width: 200px;">
                                    <a href="#" data-href="connection/delete?server=<?php echo $row["server"] ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                    <a href="/connection/connect?server=<?php echo $row["server"] ?>" class="btn btn-primary"><i class="glyphicon glyphicon-off"></i> Connect </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--/.row-->

    <div class="modal" id="addNewConnection" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #F7F7F8">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Connection</h4>
                </div>
                <form method="post" action="/connection/add" class="form-horizontal" id="connectionAddForm">
                    <div class="modal-body">
                        <div class="alert-message"></div>
                        <div class="form-body col-md-offset-1">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <label>Server</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="server" value="localhost" class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-2">
                                    <label>User</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="user" value="root" class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-2">
                                    <label>Password</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="password" class="form-control" value=""/>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-2">
                                    <label>Port</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="port" value="3306" class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-2">
                                    <label>Description</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="server_description" value="" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="testConnection()">Test</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #F7F7F8">
                    Delete Confirmation
                </div>
                <div class="modal-body">
                    Are you sure want to delete ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>

</div>    <!--/.main-->

<script src="/resources/js/jquery-1.11.1.min.js"></script>
<script src="/resources/js/bootstrap.min.js"></script>

<script>

    function testConnection() {
        $("#connectionAddForm").append('<div class="ajax-loader"></div>');
        $.ajax({
            url: "/connection/validate",
            method: "post",
            data: $("#connectionAddForm").serialize(),
            success: function (response) {
                var msg;
                if (response == "success") {
                    msg = '<div class="alert bg-success alert-dismissible" role="alert">' +
                        '<svg class="glyph stroked checkmark"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-checkmark"></use></svg> Connection success <a href="" class="pull-right" data-dismiss="alert"><span class="glyphicon glyphicon-remove"></span></a> ' +
                        '</div>'
                } else {
                    msg = '<div class="alert bg-danger alert-dismissible" role="alert"> ' +
                        '<svg class="glyph stroked cancel"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel"></use></svg> Cannot connect to this host <a href="" class="pull-right" data-dismiss="alert"><span class="glyphicon glyphicon-remove"></span></a> ' +
                        '</div>';
                }
                $("#connectionAddForm").find(".ajax-loader").remove();
                $(".alert-message").html(msg);

            }
        });
    }

    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

</script>
</body>

</html>
