<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Generator - Column</title>

    <link href="/resources/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="/resources/css/bootstrap.css" rel="stylesheet">-->
    <link href="/resources/css/styles.css" rel="stylesheet">

    <!--Icons-->
    <script src="/resources/js/lumino.glyphs.js"></script>

    <!--[if lt IE 9]>
    <script src="/resources/js/html5shiv.js"></script>
    <script src="/resources/js/respond.min.js"></script>
    <![endif]-->

    <style>
        table#column-table thead, table#column-table tbody { display: block; }

        table#column-table tbody {
            height: 270px;       /* Just for the demo          */
            overflow: auto;    /* Trigger vertical scroll    */
        }
    </style>

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
                        <?php echo $_SESSION["server"] ?> <span class="caret"></span></a>
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

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search">
        <div class="form-group">
            Database: <label><?php echo $Database ?></label>
        </div>
    </form>
    <ul class="nav menu">
        <?php foreach ($AllTables as $table) { ?>
            <li <?php if ($Table == $table) { ?> class="active" <?php } ?>>
                <a href="/table-column?database=<?php echo $Database ?>&table=<?php echo $table ?>"
                   style="word-wrap: break-word">
                    <svg class="glyph stroked calendar">
                        <use xlink:href="#stroked-calendar"></use>
                    </svg> <?php echo $table ?>
                </a>
            </li>
        <?php } ?>
    </ul>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>
            <li><a href="/">Home</a></li>
            <li><a href="/available-databases">Database</a> </li>
            <li class="active">Table</li>
        </ol>
    </div><!--/.row-->
    <br/><br/><br/>
    <div class="row">
        <div class="col-md-9">
            <?php $i = 1; ?>
            <table class="table table-bordered fixed-table-container form-inline" id="column-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Column</th>
                    <th>Type</th>
                    <th width="150px">Example</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($AllColumn as $column) { ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td>
                            <div class="column_name"><?php echo $column["COLUMN_NAME"] ?></div>
                        </td>
                        <td class="text-muted">
                            <input type="hidden" class="hidden-data-type"
                                   value="<?php echo $column["DATA_TYPE"] ?>"/> <?php echo $column["COLUMN_TYPE"] ?>
                            <input type="hidden" class="hidden-column-key" value="<?php echo $column["COLUMN_KEY"] ?>">
                        </td>
                        <td>
                            <div class="select_column">
                                <select class="select_example form-control">
                                    <option value="">Select</option>
                                    <optgroup label="Human Data">
                                        <option value="name">Names</option>
                                        <option value="phone">Phone</option>
                                        <option value="email">Email</option>
                                        <option value="date">Date / Date Time</option>
                                        <option value="company">Company</option>
                                        <option value="street">Street</option>
                                    </optgroup>
                                    <optgroup label="Text">
                                        <option value="short_text">Short Text</option>
                                        <option value="long_text">Long Text</option>
                                    </optgroup>

                                    <optgroup label="Number">
                                        <option value="number">Number</option>
                                        <option value="auto_increment">Auto Increment</option>
                                    </optgroup>

                                    <optgroup label="Extra">
                                        <option data-type="text" value="custom_list">Custom List</option>
                                        <option data-type="varchar" value="url">URL</option>
                                    </optgroup>

                                    <optgroup label="Geo">
                                        <option value="city">City</option>
                                        <option value="postal">Postal</option>
                                        <option value="region">Region</option>
                                        <option value="country">Country</option>
                                        <option value="lng">Longitude</option>
                                        <option value="lat">Latitude</option>
                                    </optgroup>

                                    <optgroup label="Login">
                                        <option value="username">Username
                                        </option>
                                        <option value="password">Password
                                        </option>
                                    </optgroup>

                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="extra-options"></div>
                        </td>
                    </tr>
                    <?php $i++ ?>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>Generate Data</h4>
                    <div class="easypiechart" id="easypiechart-blue" data-percent="0"><span class="percent">0%</span>
                    </div>
                    <div class="col-md-12" style="text-align: center"><span id="generate-speed"></span></div>
                    <div class="col-md-12" style="text-align: center; padding-top: 5px; padding-bottom: 5px;"><input
                            type="button" value="Stop" id="btn-stop" class="btn btn-danger" onclick="stop_generate()">
                    </div>
                </div>
            </div>

            <div class="col-md-7 no-padding">
                <input type="text" class="form-control" id="no_of_rows" value="1000"/>
            </div>

            <div class="col-md-5 no-padding">
                <input type="button" id="btn-generate" class="btn btn-primary pull-right" value="Generate"
                       data-toggle="modal" data-target="#confirm-delete"/>
            </div>
        </div>

    </div>

    <div class="row">
        <!--<div class="col-md-10">
            <h4>Preview Data</h4>
        </div>-->
        <div class="col-md-2">
            <input type="button" id="btn-preview"
                   class="btn btn-primary"
                   value="Preview"
                   onclick="send_json('preview',this)"/>
        </div>
    </div>
    <br/>
    <div class="row"  style="overflow: auto;">
        <div class="col-md-12">

            <table id="preview-table" class="table table-bordered fixed-table-container">
                <thead>
                <tr>
                    <?php foreach ($AllColumn as $column) { ?>
                        <th><?php echo $column["COLUMN_NAME"] ?><br/><span
                                class="text-muted"><?php echo $column["COLUMN_TYPE"] ?></span></th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #F7F7F8">
                    Data Generate Confirmation
                </div>
                <div class="modal-body">
                    Are you sure want to generate ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary btn-ok" data-dismiss="modal" onclick="generate_data()">Ok</button>
                </div>
            </div>
        </div>
    </div>

</div><!--/.row-->

</div>    <!--/.main-->

<script src="/resources/js/jquery-1.11.1.min.js"></script>
<script src="/resources/js/bootstrap.min.js"></script>
<script src="/resources/js/bootstrap-datepicker.js"></script>
<script src="/resources/js/easypiechart.js"></script>
<script src="/resources/js/easypiechart-data.js"></script>


<script>

    var current_date = "<?php echo date('Y-m-d')?>";
    var select_example = $(".select_example");
    var column_name = $(".column_name");
    var hidden_data_type = $(".hidden-data-type");

    hidden_data_type.each(function () {
        re_arrange_column(this);
    });

    select_example.change(function () {
        select_example_change(this);
    });

    select_example.first().val("auto_increment");
    $(".extra-options").first().html("auto Increment");

    function re_arrange_column(thisObj) {

        var data_type = $(thisObj).val();
        var extra_option = $(thisObj).parent().parent().find(".extra-options");
        var columns = $(thisObj).parent().parent().find(".column_name");
        var select_example_box = $(thisObj).parent().parent().find(".select_example");

        /* integer field */
        if (data_type == "int") {
            select_example_box.val('number');
            extra_option.html('<input class="form-control" type="text" value="0" /> to <input class="form-control" type="text" value="1000" />');
        } else if (data_type == "float") {
            select_example_box.val('number');
            extra_option.html('<input type="text" class="form-control" value="0.00" /> to <input type="text" class="form-control" value="1000.00" />');
        } else if (data_type == "decimal") {
            select_example_box.val('number');
            extra_option.html('<input type="text" class="form-control" value="0.00" /> to <input type="text" class="form-control" value="1000.00" />');
        } else if (data_type == "double") {
            select_example_box.val('number');
            extra_option.html('<input type="text" value="1000" class="form-control" /> to <input type="text" class="form-control" value="100000" />');
        } else if (data_type == "bigint") {
            select_example_box.val('number');
            extra_option.html('<input type="text" value="100000" class="form-control" /> to <input type="text" class="form-control" value="100000000" />');
        } else if (data_type == "tinyint") {
            select_example_box.val('number');
            extra_option.html('<input type="text" value="0" class="form-control" /> to <input type="text" value="1" class="form-control" />');
        }

        /* var char */
        else if (data_type == "varchar") {
            var field = regex_check(columns.text());
            if (field != null) {
                if (field == "name") {
                    extra_option.html("<input type='text' class='form-control' value='f|l' /> f-first, m-middle, l-last name");
                    select_example_box.val(field);
                } else if (field == "phone") {
                    extra_option.html("Prefix<input type='text' class='form-control' value='980,984,986'/> Digits<input type='text' class='form-control' value='10'/> ");
                    select_example_box.val(field);
                } else {
                    select_example_box.val(field);
                    extra_option.html("some dummy " + field);
                }
            } else {
                extra_option.html("Random short text");
                select_example_box.val("short_text");
            }
        }

        /* date field */
        else if (data_type == "date" || data_type == "datetime") {
            select_example_box.val("date");
            extra_option.html('<input type="text" class="form-control" value="' + current_date + ' 00:00:00" /> to <input type="text" class="form-control" value="' + current_date + ' 23:59:59" />');
        }

        else if (data_type == "longtext") {
            extra_option.html("Random long text");
            select_example_box.val("long_text");
        }

        else if (data_type == "enum") {
            extra_option.html('<input type="text" class="form-control" value="" placeholder="Item1 | Item2 | Item3"/>  Enter values separated by | ');
            select_example_box.val("custom_list");
        }

        /* tinytext, text, mediumtext*/
        else if (data_type == "tinytext" || data_type == "text" || data_type == "mediumtext") {
            extra_option.html("Random short text");
            select_example_box.val("short_text");
        }
    }

    function select_example_change(thisObj) {
        var select_type = $(thisObj).val();
        var extra_option = $(thisObj).parent().parent().parent().find(".extra-options");

        /* integer field */
        if (select_type == "name") {
            extra_option.html("<input type='text' class='form-control' value='f|l' /> f-first,m-middle, l-last name");
        } else if (select_type == "phone") {
            extra_option.html("Prefix<input type='text' class='form-control' value='980,984,986'/> Digits<input type='text' value='10'/> ");
        } else if (select_type == "email") {
            extra_option.html("some dummy email");
        } else if (select_type == "date") {
            extra_option.html('<input type="text" class="form-control" value="' + current_date + ' 00:00:00" /> to <input type="text" class="form-control" value="' + current_date + ' 23:59:59" />');
        } else if (select_type == "company") {
            extra_option.html("some dummy company");
        } else if (select_type == "street") {
            extra_option.html("some dummy street");
        } else if (select_type == "short_text") {
            extra_option.html("Random short text");
        } else if (select_type == "long_text") {
            extra_option.html("Random long text");
        } else if (select_type == "number") {
            extra_option.html('<input type="text" class="form-control" value="0" /> to <input type="text" class="form-control" value="1000" />');
        } else if (select_type == "auto_increment") {
            extra_option.html('Auto increment');
        } else if (select_type == "custom_list") {
            extra_option.html('<input type="text" value="" class="form-control" placeholder="Item1 | Item2 | Item3"/>  Enter values separated by | ');
        } else if (select_type == "url") {
            extra_option.html('some dummy url eg: http://dummyurl.com');
        } else if (select_type == "city") {
            extra_option.html('some dummy city Kathmandu, New York ect');
        } else if (select_type == "postal") {
            extra_option.html('random postal code eg: 977, 74, 45');
        } else if (select_type == "region") {
            extra_option.html('random postal code eg: Bagmati, Mechi');
        } else if (select_type == "country") {
            extra_option.html('random country eg: Nepal, USA, UK');
        } else if (select_type == "lat") {
            extra_option.html('random latitude');
        } else if (select_type == "lng") {
            extra_option.html('random longitude');
        } else if (select_type == "username") {
            extra_option.html('random username eg: abc123, bxt456 ');
        }
        else if (select_type == "password") {
            extra_option.html('random password');
        }
    }

    function regex_check(text) {
        var username_regex = /(.*)+(username|userName|user_name|UserName|Username)+(.*)/g;
        var password_regex = /(.*)+(password|Password)+(.*)/g;
        var name_regex = /(.*)+(name|first_name|last_name|full_name|firstname|lastname|middle_name|middlename|name)+(.*)/g;
        var email_regex = /(.*)+(email)+(.*)/;
        var msisdn_regex = /(.*)+(msisdn)+(.*)/g;
        var url_regex = /(^url+(.*))|((.*)url+)/g;

        var example = null;
        if (username_regex.test(text.toLowerCase())) {
            example = "username";
        } else if (password_regex.test(text.toLowerCase())) {
            example = "password";
        } else if (name_regex.test(text.toLowerCase())) {
            example = "name";
        } else if (email_regex.test(text.toLowerCase())) {
            example = "email";
        } else if (msisdn_regex.test(text.toLowerCase())) {
            example = "phone";
        } else if (url_regex.test(text.toLowerCase())) {
            example = "url";
        }
        return example;
    }

    function generate_data(thisObj) {
        /*if (confirm("Are you sure want to generate?")) {*/
            send_json("generate", thisObj);
        /*}*/
    }
    send_json("preview", $("#btn-preview"));
    function stop_generate() {
        clearInterval(generator_thread);
        $("#btn-preview").attr("disabled", false);
        $("#btn-generate").attr("disabled", false);
        $("#btn-stop").attr("disabled", true);
    }

    function send_json(preview_or_generate, thisObj) {
        $(thisObj).attr("disabled", true);
        var table_data = [];
        $(".extra-options").each(function () {
            //debugger;
            var row = {};
            var column = $(this).parent().parent().find(".column_name").text();
            var data_type = $(this).parent().parent().find(".hidden-data-type").val();
            var hidden_column_key = $(this).parent().parent().find(".hidden-column-key").val();
            var selected_data_type = $(this).parent().parent().find(".select_example").val();
            var options = "";
            var pipe = "";
            $(this).find('input').each(function () {
                options += pipe + $(this).val();
                pipe = "|";
            });

            row["column"] = column;
            row["data_type"] = data_type;
            row["hidden_column_key"] = hidden_column_key;
            row["selected_data_type"] = selected_data_type;
            row["options"] = options;
            table_data.push(row);
        });
        var myJsonString = JSON.stringify(table_data);
        var table_name = "<?php echo $Table?>";
        var database_name = "<?php echo $Database ?>";
        var speed = 1000;
        var busy = false;
        var batch_size = 100;
        var no_of_rows = parseInt($("#no_of_rows").val());
        var buffer_size = 10;
        if (preview_or_generate == "preview") {
            buffer_size = 10;
            $("#btn-stop").attr("disabled", true);
        }

        if (preview_or_generate == "generate") {
            $("#btn-stop").attr("disabled", false);
            $("#btn-generate").attr("disabled", true);
            $("#btn-preview").attr("disabled", true);
        }

        var processed_data = 0;
        var totalData = parseInt($("#no_of_rows").val());
        generator_thread = setInterval(function () {
            if (!busy) {
                busy = true;
                $("#generate-speed").text(processed_data + " processed ");
                var percentageComplete = parseInt((processed_data / totalData) * 100);
                $("#easypiechart-blue").attr('data-percent', percentageComplete);
                $("#easypiechart-blue").find(".percent").text(percentageComplete + "%");
                if (no_of_rows < buffer_size * batch_size) {
                    buffer_size = 1;
                    if (no_of_rows < batch_size) {
                        if (no_of_rows < 1) {
                            stop_generate();
                            return;
                        }
                        batch_size = no_of_rows;
                    }
                }

                var ajax_call = (function () {
                    var json = null;
                    $.ajax({
                        async: false,
                        cache: false,
                        url: "/data-generate",
                        method: "post",
                        data: {
                            json: myJsonString,
                            no_of_rows: buffer_size,
                            table: table_name,
                            database: database_name,
                            preview_or_generate: preview_or_generate,
                            batch_size: batch_size
                        },
                        success: function (response) {

                            if (preview_or_generate == "preview") {
                                var json_parse = JSON.parse(response);
                                $("#preview-table").find('tbody').html("");
                                json_parse.forEach(function (row) {
                                    var tr = $("<tr/>");

                                    row.forEach(function (col) {
                                        var td = $("<td/>");
                                        td.append("<div class='td-height'>" + col + "</div>");
                                        tr.append(td);
                                    });

                                    $("#preview-table").find('tbody').append(tr);
                                });

                            } else if (preview_or_generate == "generate") {
                                if (response == "error") {
                                    $("#generate-speed").text("SQL error!!, please check data type properly");
                                    stop_generate();
                                }
                            }
                        }
                    });
                    busy = false;
                    processed_data += buffer_size * batch_size;
                    no_of_rows -= buffer_size * batch_size;
                    return json;
                })();
            }

            if (preview_or_generate == "preview") {
                stop_generate()
            }

        }, speed);
    }

    // Change the selector if needed
    var $table = $('table#column-table'),
        $bodyCells = $table.find('tbody tr:first').children(),
        colWidth;

    // Get the tbody columns width array
    colWidth = $bodyCells.map(function() {
        return $(this).width();
    }).get();

    // Set the width of thead columns
    $table.find('thead tr').children().each(function(i, v) {
        $(v).width(colWidth[i]);
    });

</script>
</body>

</html>
