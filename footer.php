<!-- Footer -->
<footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <ul class="list-inline text-center">
                        <li class="list-inline-item">
                            <a href="<?php echo PATH; ?>" >
                            <!-- <a href="https://www.facebook.com/Jaroon-Freelance-2305305863090538" target="_blank"> -->
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-muted">Copyright &copy; Jaroon Software 2022-<?php echo date("Y"); ?></p>
                </div>
            </div>
        </div>
    </footer>
    <?php
        define('ROOT_JS',str_replace("\\",'/',dirname(__FILE__)));
        define('PATH_JS', ROOT_JS == $_SERVER['DOCUMENT_ROOT']
            ?'' :substr(ROOT_JS,strlen($_SERVER['DOCUMENT_ROOT']))
        );
    ?>
    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo PATH_JS; ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo PATH_JS; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="<?php echo PATH_JS; ?>/js/clean-blog.min.js"></script>