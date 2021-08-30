<?php
if (isset($_SESSION['users'])) {
    header("Location: index.php?page=status_403");
}
?>
<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-6 mx-auto my-5">
                <?php
                if (isset($_SESSION['errors'])) :
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['errors'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION['errors']);
                endif; ?>
                <form action="models/actions/login.php" method="POST">
                    <div class="mb-3">
                        <label for="loginEmail">Email:</label>
                        <input type="email" name="loginEmail" id="loginEmail" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword">Password:</label>
                        <input type="password" name="loginPassword" id="loginPassword" class="form-control">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit" name="btnSubmitLogin">Login</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>