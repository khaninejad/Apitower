<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>No Message</strong>
                                    <span class="pull-right text-muted">
                                        <em>Today</em>
                                    </span>
                                </div>
                                <div></div>
                            </a>
                        </li>
                        @if (Session::has('unread_feed'))
                         <li>
                            <a href="feeds/readall">
                                <div>
                                    <strong>Unread feed</strong>
                                    <span class="pull-right text-muted">
                                        <em>{{ Session::get('unread_feed') }}</em>
                                    </span>
                                </div>
                                <div></div>
                            </a>
                        </li>
                        @endif
                        <li class="divider"></li>

                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                       <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>-->
                        <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->