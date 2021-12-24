<main class="container">
    <div class="row my-3">
        <div class="col-lg-6 mx-auto">
            <div id="printEmailMessage"></div>
            <h1 class="text-center fs-1">Contact us</h1>
            <form action="models/action/contactus.php">
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-6">
                        <label for="firstName" class="col-form-label">First name:</label>
                        <input type="text" name="firstName" id="firstName" class="form-control">
                        <em id="contactFirstNameErrorMessage"></em>
                    </div>
                    <div class="col-6">
                        <label for="lastName" class="col-form-label">Last name:</label>
                        <input type="text" name="lastName" id="lastName" class="form-control">
                        <em id="contactLastNameErrorMessage"></em>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" class="form-control" value="">
                    <em id="contactEmailErrorMessage"></em>
                </div>
                <div class="mb-3">
                    <label for="message">Message:</label>
                    <textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
                    <em id="contactMessageErrorMessage"></em>
                </div>
                <div class="row">
                    <div class="col-lg-3 flaot-end">
                        <div class="d-grid"><button class="btn btn-primary" id="btnContactUs">Contact us</button></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>