<?php
include_once('config.php'); 
?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="<?php echo PATH; ?>">เทพกระษัตรี 2019 คอนสตรัคชั่น</a>
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

                    <body>
                        <div class="login">
                            <h1> <img src="img/logo.jpg" width="100px;"></h1>
                            <form action="login_result.php" method="post">

                                <label for="username">
                                    <i class="fas fa-user"></i>
                                </label>
                                <input type="text" name="username" placeholder="Username" id="username" required>

                                <label for="password">
                                    <i class="fas fa-lock"></i>
                                </label>
                                <input type="password" name="password" placeholder="Password" id="password" required>

                                <input type="submit" value="Login">
                            </form>
                        </div>
                    </body>
                    <!-- <h2>Pokémon Database</h2>
                        <span class="subheading">News & Updates</span> -->
                </div>
            </div>
        </div>

        
    </div>
</header>