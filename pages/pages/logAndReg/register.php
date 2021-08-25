<?php if (isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}
?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-6 mx-auto">
                <div id="registerResponseErrorMessage"></div>
                <form action="#" method="#">
                    <div class="mb-3">
                        <label for="userFirstName">First name:</label>
                        <input type="text" name="userFirstName" id="userFirstName" class="form-control">
                        <em id="userFirstNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="userLastName">Last name:</label>
                        <input type="text" name="userLastNamme" id="userLastName" class="form-control">
                        <em id="userLastNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail">Email:</label>
                        <input type="email" name="userEmail" id="userEmail" class="form-control">
                        <em id="userEmailErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="userPassword">Password:</label>
                        <input type="password" name="userPassword" id="userPassword" class="form-control">
                        <em id="userPasswordErrorMessage"></em>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="button" id="btnRegister">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>