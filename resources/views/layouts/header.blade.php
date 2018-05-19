<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">SGPE</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="#">Link 4</a></li>
                <li><a href="#">Link 5</a></li>
                <li><a href="#">Link 6</a></li>
                <li><a href="#">Link 7</a></li>
                <li><a href="#">Link 8</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                </div>
            </form>
        </div> -->
        
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </a>


        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Auth::check())
                        <b>{{ Auth::user()->name }}</b><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                        @else
                        <b>Usuario Deslogado </b><span class="caret"></span>
                    </a>
                        @endif
                </li>
            </ul>
        </div>
    </nav>
</header>