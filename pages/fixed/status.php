<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-4 mx-auto">
                <?php
                $status = isset($_GET['code']) ? $_GET['code'] : 404;

                $message = '';
                switch ($status) {
                    case 401:
                        $message = 'Unauthorized Error';
                        break;
                    case 404:
                        $message = "Page not found";
                }
                ?>
                <div class="text-center">
                    <h1 class="large-font text-danger text-center"><?= $status ?></span></h1>
                    <p class="fs-2 text-center fw-bold"><?= $message ?></p>
                    <?php
                    if (isset($_SESSION['user'])) :
                        if ($_SESSION['user']->roleName == "User") :
                    ?>
                            <a href="index.php" class="btn btn-outline-primary ">Back to the home page</a>
                        <?php else : ?>
                            <a href="admin.php" class="btn btn-outline-primary">Back to the home page</a>
                    <?php endif;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>