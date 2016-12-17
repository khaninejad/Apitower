<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav in" id="side-menu">
                        <li>
                            <a class="active" href=" {{ URL::to('/') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                         <li>
                            <a href="{{ URL::to('website') }}"><i class="fa fa-edit fa-fw"></i> Domain</a>
                        </li>
                          <li>
                            <a href="{{ URL::to('feeds') }}"><i class="fa fa-rss fa-fw"></i> Feeds</a>
                        </li>
                          <li>
                            <a href="{{ URL::to('post/postlist') }}"><i class="fa fa-th-list"></i> Posts</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('mixer') }}"><i class="fa fa-plus-square-o"></i> Mixer</a>
                        </li>
                           <li>
                            <a href="{{ URL::to('team') }}"><i class="fa fa-users"></i> Team</a>
                        </li>
                         <li>
                            <a href="{{ URL::to('support/create') }}"><i class="fa fa-life-ring"></i> Support</a>
                        </li>
                       
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
                </div>