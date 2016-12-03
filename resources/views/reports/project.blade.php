<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Report</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>
        $(document).on('click', '.panel-heading span.clickable', function(e){
            if(!$(this).hasClass('panel-collapsed')) {
                $(this).parents('.collapseable').find('.panel-body').first().slideUp();
                $(this).addClass('panel-collapsed');
                $(this).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            } else {
                $(this).parents('.collapseable').find('.panel-body').first().slideDown();
                $(this).removeClass('panel-collapsed');
                $(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            }
        });
    </script>

    <style>
        .row{
            margin-top:40px;
            padding: 0 14px;
        }

        .clickable{
            cursor: pointer;
        }

        .panel-heading span {
            margin-top: -20px;
            font-size: 15px;
        }

        .panel-body {
            padding: 4px;
        }

        .table {
            margin-bottom: 0;
        }

        .panel, .panel-heading {
            border-radius: 0;
        }

        body {
            background-color: #ecf0f1;
        }
    </style>
</head>

<body>

<br>
    @if($errorMsg != null)
        <div class="container container-fluid">
            <div class="alert alert-danger" role="alert">
                <p>{{$errorMsg}}</p>
            </div>
        </div>
    @else
        <div class="container container-fluid panel panel-default panel-heading">
        <div class="panel panel-group row">
            <div class="panel-heading">
                <h3 class="panel-title">Project - {{$project->id}}</h3>
            </div>
            <!-- Project summary table -->
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Σ Set(s)</th>
                    <th>Σ Weight(s)</th>
                    <th>Σ Sales price</th>
                    <th>Σ Purchase price</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{$project->id}}</td>
                    <td>{{$project->name}}</td>
                    <td>{{count($project->sets)}}</td>
                    <td>{{$project->weight_total}} kg</td>
                    <td>{{$currency . $project->total_sales_price}}</td>
                    <td>{{$currency . $project->total_purchase_price}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        @foreach($project->sets as $set)
            <div class="row">
                <div class="panel panel-primary collapseable">
                    <div class="panel-heading">
                        <h3 class="panel-title">Set - {{$set->id}}</h3>
                        <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Σ Part(s)</th>
                                <th>Σ Weight(s)</th>
                                <th>Σ Sales price</th>
                                <th>Σ Purchase price</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>{{$set->id}}</td>
                                <td>{{$set->name}}</td>
                                <td>{{count($set->parts)}}</td>
                                <td>{{$set->weight_total}} kg</td>
                                <td>{{$currency . $set->total_sales_price}}</td>
                                <td>{{$currency . $set->total_purchase_price}}</td>
                            </tr>
                            </tbody>
                        </table>

                        @if (count($set->parts) > 0)
                            <br>

                            <div class="panel panel-group">
                                <h2 class="panel panel-group panel-title">Part(s)</h2>
                            </div>

                            <table class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Weight</th>
                                    <th>Units</th>
                                    <th>Stock</th>
                                    <th>Length</th>
                                    <th>Width</th>
                                    <th>Sales price</th>
                                    <th>Purchase price</th>
                                </tr>
                                </thead>

                                @foreach($set->parts as $part)
                                    <tbody>
                                    <tr>
                                        <td>{{$part->id}}</td>
                                        <td>{{$part->name}}</td>
                                        <td>{{$part->weight}}</td>
                                        <td>{{$part->units}}</td>
                                        <td>{{$part->stock}}</td>
                                        <td>{{$part->length}}</td>
                                        <td>{{$part->width}}</td>
                                        <td>{{$currency . $part->sales_price}}</td>
                                        <td>{{$currency . $part->purchase_price}}</td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @endif
</body>
</html>