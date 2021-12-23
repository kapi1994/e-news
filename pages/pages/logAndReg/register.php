<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-6 mx-auto">
                <div id="registerResponseErrorMessage"></div>
                <h1 class="text-center">Register</h1>
                <form action="#">
                    <div class="mb-3">
                        <label for="userFirstName">First name:</label>
                        <input type="text" name="userFirstName" id="userFirstName" class="form-control">
                        <em id="userFirstNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="userLastName">Last name:</label>
                        <input type="text" name="userLastName" id="userLastName" class="form-control">
                        <em id="userLastNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="iserEmail">Email:</label>
                        <input type="email" name="userEmail" id="userEmail" class="form-control">
                        <em id="userEmailErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="userPassword">Password:</label>
                        <input type="password" name="userPassword" id="userPassword" class="form-control">
                        <em id="userPasswordErrorMessage"></em>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" id="btnRegister" type="button">Registrujte se</button>
                        <a href="index.php?page=login" class="btn btn-outline-dark">Imate nalog? Ulogujte se</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>