<section>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $user = getOneFetchAndCheckData("users", 'id', $_GET['id'], "fetch");
        }
        ?>
        <div class="row my-5">
            <div class="col-lg-6 mx-auto">
                <form method="POST">
                    <div class="mb-3">
                        <label for="" class="mb-1">First name:</label>
                        <input type="text" name="userFirstName" id="userFirstName" class="form-control" value="<?= isset($_GET['id']) ? $user->first_name : '' ?>">
                        <em id="userFirstNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">Last name:</label>
                        <input type="text" name="userLastName" id="userLastName" class="form-control" value="<?= isset($_GET['id']) ? $user->last_name : '' ?>">
                        <em id="userLastNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">Email:</label>
                        <input type="email" name="userEmail" id="userEmail" class="form-control" value="<?= isset($_GET['id']) ? $user->email : '' ?>">
                        <em id="userEmailErrorMessage"></em>
                    </div>
                    <?php if (!isset($_GET['id'])) : ?>
                        <div class="mb-3">
                            <label for="" class="mb-1">Password:</label>
                            <input type="password" name="userPassword" id="userPassword" class="form-control">
                        </div>
                        <em id="userPasswordErrorMessage"></em>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="" class="mb-1">Roles:</label>
                        <?php
                        $roles = getAll('roles');
                        foreach ($roles as $role) :
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userRole" id="userRole<?= $role->id ?>" value="<?= $role->id ?>" <?php if (isset($_GET['id']) && $role->id == $user->role_id) : ?> checked<?php else : ?><?php endif; ?>>
                                <label class="form-check-label" for="userRole<?= $role->id ?>">
                                    <?= $role->name ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="d-grid"><button class="btn btn-primary"><?php if (isset($_GET['id'])) : ?>Update<?php else : ?> Save<?php endif; ?></button></div>
                </form>
            </div>
        </div>
    </div>
</section>