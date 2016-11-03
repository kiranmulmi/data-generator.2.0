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

    <link rel="stylesheet" href="/resources/font-awesome-4.6.3/css/font-awesome.min.css">

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

            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <svg class="glyph stroked male-user">
                            <use xlink:href="#stroked-male-user"></use>
                        </svg>
                        <?php echo $_SESSION["server"]?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="connection/logout">
                                <svg class="glyph stroked cancel">
                                    <use xlink:href="#stroked-cancel"></use>
                                </svg>
                                Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </div><!-- /.container-fluid -->
</nav>


<div class="col-sm-9 col-sm-offset-2 col-lg-10 col-lg-offset-1 main">

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li><a href="/">Home</a></li>
            <li class="active">Database</li>
        </ol>
    </div><!--/.row-->
    <div class="clearfix"></div>
    <br/><br/><br/>
    <div class="row">
        <div class="col-md-12">
            <?php foreach ($AllDatabase as $database) { ?>
                <a href="/existing-tables?database=<?php echo $database ?>">
                    <div class="col-xs-12 col-md-6 col-lg-3">
                        <div class="panel panel-blue panel-widget ">
                            <div class="row no-padding">
                                <div class="col-sm-3 col-lg-5 widget-left">
                                    <i class="fa fa-database fa-4x" aria-hidden="true"></i>
                                </div>
                                <div class="col-sm-9 col-lg-7 widget-right">
                                    <!--<div class="large">120</div>-->
                                    <div class="text-muted"><?php echo $database ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>

        </div><!--/.col-->
    </div>
</div><!--/.row-->

</div>    <!--/.main-->

<script src="/resources/js/jquery-1.11.1.min.js"></script>
<script src="/resources/js/bootstrap.min.js"></script>

</body>

</html>
