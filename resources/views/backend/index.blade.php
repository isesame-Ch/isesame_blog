
@extends('layouts.backend')
@section('css')
    <!-- Vector Map  -->
    <link rel="stylesheet" href="/js/plugins/jvectormap/css/jquery-jvectormap-1.2.2.css">
    <!-- ToDos  -->
    <link rel="stylesheet" href="/js/plugins/todo/css/todos.css">
    <!-- Morris  -->
    <link rel="stylesheet" href="/js/plugins/morris/css/morris.css">
@stop
@section('main_content')
    <!--main content start-->
    <section class="main-content-wrapper">
        <section id="main-content">
            <!--tiles start-->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-tile detail tile-red">
                        <div class="content">
                            <h1 class="text-left timer" data-from="0" data-to="180" data-speed="2500"></h1>
                            <p>New Users</p>
                        </div>
                        <div class="icon"><i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-tile detail tile-turquoise">
                        <div class="content">
                            <h1 class="text-left timer" data-from="0" data-to="56" data-speed="2500"></h1>
                            <p>New Comments</p>
                        </div>
                        <div class="icon"><i class="fa fa-comments"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-tile detail tile-blue">
                        <div class="content">
                            <h1 class="text-left timer" data-from="0" data-to="32" data-speed="2500"></h1>
                            <p>New Messages</p>
                        </div>
                        <div class="icon"><i class="fa fa fa-envelope"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-tile detail tile-purple">
                        <div class="content">
                            <h1 class="text-left timer" data-to="105" data-speed="2500"></h1>
                            <p>New Sales</p>
                        </div>
                        <div class="icon"><i class="fa fa-bar-chart-o"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!--tiles end-->
            <!--dashboard charts and map start-->
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Sales for 2014</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="sales-chart" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Office locations</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="map" id="map" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--dashboard charts and map end-->
            <!--ToDo start-->
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">To do list</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="new-todo" type="text" class="form-control" placeholder="What needs to be done?">
                                        <section id='main'>
                                            <ul id='todo-list'></ul>
                                        </section>
                                    </div>
                                    <div class="form-group">
                                        <button id="todo-enter" class="btn btn-primary pull-right">Submit</button>
                                        <div id='todo-count'></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Server Status</h3>
                                    <div class="actions pull-right">
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                                <div class="panel-body">

                                    <span class="sublabel">Memory Usage</span>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-info" style="width: 20%">20%</div>
                                    </div>
                                    <!-- progress -->

                                    <span class="sublabel">CPU Usage</span>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-default" style="width: 60%">60%</div>
                                    </div>
                                    <!-- progress -->

                                    <span class="sublabel">Disk Usage</span>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-primary" style="width: 80%">80%</div>
                                    </div>
                                    <!-- progress -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-solid-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Weather</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="text-center small-thin uppercase">Today</h3>
                                    <div class="text-center">
                                        <canvas id="clear-day" width="110" height="110"></canvas>
                                        <h4>62°C</h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="text-center small-thin uppercase">Tonight</h3>
                                    <div class="text-center">
                                        <canvas id="partly-cloudy-night" width="110" height="110"></canvas>
                                        <h4>44°C</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-2">
                                    <h6 class="text-center small-thin uppercase">Mon</h6>
                                    <div class="text-center">
                                        <canvas id="partly-cloudy-day" width="32" height="32"></canvas>
                                        <span>48°C</span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <h6 class="text-center small-thin uppercase">Mon</h6>
                                    <div class="text-center">
                                        <canvas id="rain" width="32" height="32"></canvas>
                                        <span>39°C</span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <h6 class="text-center small-thin uppercase">Tue</h6>
                                    <div class="text-center">
                                        <canvas id="sleet" width="32" height="32"></canvas>
                                        <span>32°C</span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <h6 class="text-center small-thin uppercase">Wed</h6>
                                    <div class="text-center">
                                        <canvas id="snow" width="32" height="32"></canvas>
                                        <span>28°C</span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <h6 class="text-center small-thin uppercase">Thu</h6>
                                    <div class="text-center">
                                        <canvas id="wind" width="32" height="32"></canvas>
                                        <span>40°C</span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <h6 class="text-center small-thin uppercase">Fri</h6>
                                    <div class="text-center">
                                        <canvas id="fog" width="32" height="32"></canvas>
                                        <span>42°C</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4>Browser Summary</h4>
                            <div id="donut-example"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--ToDo end-->
        </section>
    </section>
    <!--main content end-->
@stop

@section('sidebar_right')
    <!--sidebar right start-->
    <aside class="sidebarRight">
        <div id="rightside-navigation ">
            <div class="sidebar-heading"><i class="fa fa-user"></i> Contacts</div>
            <div class="sidebar-title">online</div>
            <div class="list-contacts">
                <a href="javascript:void(0)" class="list-item">
                    <div class="list-item-image">
                        <img src="/img/backend/avatar.gif" class="img-circle">
                    </div>
                    <div class="list-item-content">
                        <h4>James Bagian</h4>
                        <p>Los Angeles, CA</p>
                    </div>
                    <div class="item-status item-status-online"></div>
                </a>
                <a href="javascript:void(0)" class="list-item">
                    <div class="list-item-image">
                        <img src="/img/backend/avatar1.gif" class="img-circle">
                    </div>
                    <div class="list-item-content">
                        <h4>Jeffrey Ashby</h4>
                        <p>New York, NY</p>
                    </div>
                    <div class="item-status item-status-online"></div>
                </a>
                <a href="javascript:void(0)" class="list-item">
                    <div class="list-item-image">
                        <img src="/img/backend/avatar2.gif" class="img-circle">
                    </div>
                    <div class="list-item-content">
                        <h4>John Douey</h4>
                        <p>Dallas, TX</p>
                    </div>
                    <div class="item-status item-status-online"></div>
                </a>
                <a href="javascript:void(0)" class="list-item">
                    <div class="list-item-image">
                        <img src="/img/backend/avatar3.gif" class="img-circle">
                    </div>
                    <div class="list-item-content">
                        <h4>Ellen Baker</h4>
                        <p>London</p>
                    </div>
                    <div class="item-status item-status-away"></div>
                </a>
            </div>

            <div class="sidebar-title">offline</div>
            <div class="list-contacts">
                <a href="javascript:void(0)" class="list-item">
                    <div class="list-item-image">
                        <img src="/img/backend/avatar4.gif" class="img-circle">
                    </div>
                    <div class="list-item-content">
                        <h4>Ivan Bella</h4>
                        <p>Tokyo, Japan</p>
                    </div>
                    <div class="item-status"></div>
                </a>
                <a href="javascript:void(0)" class="list-item">
                    <div class="list-item-image">
                        <img src="/img/backend/avatar5.gif" class="img-circle">
                    </div>
                    <div class="list-item-content">
                        <h4>Gerald Carr</h4>
                        <p>Seattle, WA</p>
                    </div>
                    <div class="item-status"></div>
                </a>
                <a href="javascript:void(0)" class="list-item">
                    <div class="list-item-image">
                        <img src="/img/backend/avatar6.gif" class="img-circle">
                    </div>
                    <div class="list-item-content">
                        <h4>Viktor Gorbatko</h4>
                        <p>Palo Alto, CA</p>
                    </div>
                    <div class="item-status"></div>
                </a>
            </div>
        </div>
    </aside>
    <!--sidebar right end-->
@stop

<!--Load these page level functions-->
@section('js')
    <!-- FlotCharts  -->
    <script src="/js/plugins/flot/js/jquery.flot.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.resize.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.canvas.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.image.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.categories.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.crosshair.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.errorbars.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.fillbetween.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.navigate.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.pie.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.selection.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.stack.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.symbol.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.threshold.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.colorhelpers.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.time.min.js"></script>
    <script src="/js/plugins/flot/js/jquery.flot.example.js"></script>
    <!-- Morris  -->
    <script src="/js/plugins/morris/js/morris.min.js"></script>
    <script src="/js/plugins/morris/js/raphael.2.1.0.min.js"></script>
    <!-- Vector Map  -->
    <script src="/js/plugins/jvectormap/js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/js/plugins/jvectormap/js/jquery-jvectormap-world-mill-en.js"></script>
    <!-- ToDo List  -->
    <script src="/js/plugins/todo/js/todos.js"></script>
    <!--Page Level JS-->
    <script src="/js/plugins/countTo/jquery.countTo.js"></script>
    <script src="/js/plugins/weather/js/skycons.js"></script>
    <script>
        $(document).ready(function() {
            app.timer();
            app.map();
            app.weather();
            app.morrisPie();
        });
    </script>
@stop

