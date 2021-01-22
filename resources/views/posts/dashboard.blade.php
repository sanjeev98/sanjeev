@extends('layouts.app')

@section('content')

    <div class="row" style="position: relative;">
        <label>From:</label>
        <input type="date" id="from-date">
        <label>To:</label>
        <input type="date" id="to-date">
        <button class="search">search</button>
        <div class="col-9">
            <table class="table mt-4" id="post-table">
                <thead>
                <th>Id</th>
                <th>Title</th>
                <th>Description</th>
                <th>posted By</th>
                <th>Tag</th>
                <th>Date</th>
                <th>Action</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <figure class="highcharts-figure">
                <div id="bar-chart"></div>
                <br>
                <div id="graph-chart"></div>
            </figure>
        </div>
        <div class="col-3">
            <div class="tags">
                <article class="card-group-item">
                    <header class="card-header"><h6 class="title">Tag</h6></header>
                    <div class="filter-content">
                        <div class="card-body">
                            @foreach($latest_tag as $tag)
                                <button class="btn btn-success tag" data-id="{{ $tag->name }}">
                                    <span class="form-check-label">{{ $tag->name }}</span>
                                    <span class="badge badge-pill badge-primary">{{ $tag->posts_count }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </article>
                <article class="card-group-item">
                    <header class="card-header"><h6 class="title">Post</h6></header>
                    <div class="filter-content">
                        <div class="card-body">
                            @foreach($latest_post as $post)
                                <button class="btn btn-success post" data-id="{{ $post->title }}">
                                    <span class="form-check-label">{{ $post->title }}</span>
                                    <span
                                        class="badge badge-pill badge-primary">{{ $post->created_at->diffForHumans() }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.js"
            integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        $(function () {
            $('#post-table').DataTable({
                data:{!! json_encode($posts_table) !!},
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'posted_by', name: 'posted_by'},
                    {data: 'tags[].name', name: 'tags[].name'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: "action",
                        "render": function (data, type, row, meta) {
                            data = '<a class="btn btn-info" href="posts/' + row['id'] + '">show</a>';
                            return data;
                        },
                        orderable: false, searchable: false
                    }
                ]
            });
        });
        $('body').on('click', '.post', function () {
            var table = $('#post-table').DataTable();
            var post_title = $(this).data('id');
            table.column(1).search(post_title).draw();
        });
        $('body').on('click', '.tag', function () {
            var table = $('#post-table').DataTable();
            var tag = $(this).data('id');
            table.column(4).search(user_id).draw();
        });
        $('body').on('click', '.search', function () {
            $.fn.dataTableExt.afnFiltering.push(
                function (settings, data, dataIndex) {
                    var min = $('#from-date').val();
                    var max = $('#to-date').val();
                    var startDate = data[5];
                    if (min == null && max == null) {
                        return true;
                    }
                    if (min == null && startDate <= max) {
                        return true;
                    }
                    if (max == null && startDate >= min) {
                        return true;
                    }
                    if (startDate <= max && startDate >= min) {
                        return true;
                    }
                    return false;
                }
            );
            var table = $('#post-table').DataTable();
            table.draw();
        });
        Highcharts.chart('bar-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Posts And Users'
            },
            subtitle: {
                text: 'Source: Posts And Users'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'No Of Posts And Users'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} {series.name}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Posts',
                data: {!! json_encode($posts_chart) !!}

            }, {
                name: 'Users',
                data: {!! json_encode($users_chart) !!}

            }]
        });
        Highcharts.chart('graph-chart', {
            title: {
                text: ', Posts And Users 2010-2020'
            },
            subtitle: {
                text: 'Source: Posts And Users'
            },
            yAxis: {
                title: {
                    text: 'Number Of Posts and Users'
                }
            },
            xAxis: {
                accessibility: {
                    rangeDescription: 'Range:2010 to 2020'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    pointStart: 2010
                }
            },
            series: [{
                name: 'Posts',
                data: {!! json_encode($posts_graph) !!}
            }, {
                name: 'Users',
                data: {!! json_encode($users_graph) !!}
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    </script>
@endsection
