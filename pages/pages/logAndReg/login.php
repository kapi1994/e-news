<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-6 mx-auto">
                <ul class="list-group">
                    <?php

                    if (isset($_SESSION['errors'])) :
                        $errors = $_SESSION['errors'];
                        foreach ($errors as $error) :
                    ?>
                            <div class="alert alert-danger fw-bolder" role="alert">
                                <?= $error ?>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    session_destroy();
                    ?>
                </ul>

                <form action="models/action/login.php" method="POST">
                    <div class="mb-3">
                        <label for="">Email:</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Password:</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="d-grid"><button type='submit' class="btn btn-primary" name='btnSubmit'>Ulogujte se</button></div>
                </form>
            </div>
        </div>
    </div>
</section>