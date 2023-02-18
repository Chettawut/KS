<?php
include_once('config.php'); 
?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="<?php echo PATH; ?>">OC Money Group</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PATH; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PATH; ?>">ติดต่อเรา</a>
                    </li>
                    <li class="nav-item">
                    <!-- <a class="nav-link" href="<?php echo PATH; ?>/backend">Login</a> -->
                        <a class="nav-link" data-toggle="modal" data-target="#exampleModalCenter">Login</a>
                    </li>
                    <!-- <li class="nav-item">
            <a class="nav-link" href="post.html">Sample Post</a>
          </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="">About</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('<?php echo PATH; ?>/img/home-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <!-- <h2>Pokémon Database</h2>
                        <span class="subheading">News & Updates</span> -->
                    </div>
                </div>
            </div>
        </div>
    </header>