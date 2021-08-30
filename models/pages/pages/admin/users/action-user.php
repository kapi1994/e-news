<?php
if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}
if (isset($_GET['id'])) {
    $user = getDataWithFetch('users', 'id', $_GET['id']);
}
?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-6 <?php if (!isset($_GET['id'])) : ?> mx-auto <?php endif; ?>">

                <em id="crudUserErrorMessage"></em>
                <form action="#" method="#">
                    <input type="hidden" name="userId" id="userId" value="<?= isset($user) ? $user->id : '' ?>">
                    <div class="mb-3">
                        <label for="userFirstName">First name:</label>
                        <input type="text" name="userFirstName" id="userFirstName" class="form-control" value="<?= isset($user) ? $user->first_name : '' ?>">
                        <em id="userFirstNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="userLastName">Last name:</label>
                        <input type="text" name="userLastName" id="userLastName" class="form-control" value="<?= isset($user) ? $user->last_name : '' ?>">
                        <em id="userLastNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail">Email:</label>
                        <input type="email" name="userEmail" id="userEmail" class="form-control" value="<?= isset($user) ? $user->email : '' ?>">
                        <em id="userEmailErrorMessage"></em>
                    </div>

                    <?php
                    if (!isset($_GET['id'])) :
                    ?>
                        <div class="mb-3">
                            <label for="userPassword">Password:</label>
                            <input type="password" name="userPassword" id="userPassword" class="form-control">
                            <em id="userPasswordErrorMessage"></em>
                        </div>
                    <?php endif ?>
                    <div class="mb-3">
                        <label for="userRole">Role:</label>
                        <?php
                        $roles = getAll('roles');
                        foreach ($roles as $role) :
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userRole" id="role_<?= $role->id ?>" value="<?= $role->id ?>" <?php if (isset($roles) && isset($user) && ($role->id == $user->role_id)) : ?> checked <?php else : ?> <?php endif; ?>>
                                <label class="form-check-label" for="role_<?= $role->id ?>">
                                    <?= $role->name ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        <em id="userRoleErrorMessage"></em>
                    </div>
                    <div class="d-grid"><button class="btn btn-primary" type="button" id="btnSumbitUser">Submit</button></div>
                </form>
            </div>
            <?php
            if (isset($_GET['id'])) :
            ?>
                <div class="col-6">
                    <form action="#" method="#">
                        <input type="hidden" name="userResetId" id="userResetId" value=<?= $user->id ?>>
                        <div class="mb-3">
                            <label for="userFirstNameLast">Change user for:</label>
                            <input type="text" name="userFirstLastName" id="yserFirstLastName" class="form-control" value="<?= $user->first_name . ' ' . $user->last_name ?> " disabled>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword">Password:</label>
                            <input type="password" name="userChangePassword" id="userChangePassword" class="form-control">
                        </div>
                        <div class="d-grid"><button class="btn btn-primary" id="btnChangePassword">Change password</button></div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>