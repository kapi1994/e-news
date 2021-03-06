<?php
if (isset($_SESSION['user'])) {
    header("Location: index.php?page=status");
}
?>
<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-6 mx-auto">
                <?php
                if (isset($_SESSION['activateAcc'])) :
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Your account is reactivated</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION['activateAcc']);
                endif; ?>

                <ul class="list-group">
                    <?php

                    if (isset($_SESSION['errors'])) :
                        if (is_array($_SESSION['errors'])) :
                            $errors = $_SESSION['errors'];
                            foreach ($errors as $error) :
                    ?>
                                <div class="alert alert-danger fw-bolder" role="alert">
                                    <?= $error ?>
                                </div>
                            <?php
                            endforeach;
                        else :
                            $error = $_SESSION['errors'];
                            ?>

                            <div class="alert alert-danger fw-bolder" role="alert">
                                <?= $error ?>
                            </div>
                    <?php
                        endif;
                    endif;
                    unset($_SESSION['errors']);
                    ?>
                </ul>

                <form action="models/action/login.php" method="POST">
                    <h1 class="text-center">Login</h1>
                    <div class="mb-3">
                        <label for="">Email:</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Password:</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="d-grid gap-2">
                        <button type='submit' class="btn btn-primary" name='btnSubmit'>Ulogujte se</button>
                        <a href="index.php?page=register" class="btn btn-outline-dark">Ako nemate nalog? Registrujte se.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>