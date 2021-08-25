<?php
if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
} ?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3">
                <div class="my-2">
                    <div class="d-grid">
                        <a href="index.php?page=action-user" class="btn btn-primary">Create a new user</a>
                    </div>
                </div>
                <div class="my-2">
                    <input type="text" name="searchUser" id="searchUser" class="form-control" placeholder="Search users....">
                </div>
                <div class="my-2">
                    <select name="sortByDateUsers" id="sortByDateUsers" class="form-select">
                        <option value="0">Choose</option>
                        <option value="1">Opadajucem</option>
                        <option value="2">Rastucem</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="table-responsive-sm table-responsive-md">
                        <table class="table text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Full name</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="users">
                                <?php
                                $rb = 1;
                                $users = getAll('users');
                                if (count($users) > 0) :
                                    foreach ($users as $user) :
                                ?>
                                        <tr>
                                            <th scope="row"><?= $rb++ ?></th>
                                            <td><?= $user->first_name . ' ' . $user->last_name ?></td>
                                            <td><?= $user->email ?></td>
                                            <td><?= $user->created_at ?></td>
                                            <td><?= $user->updated_at ? $user->updated_at : '-' ?></td>
                                            <td><a href="index.php?page=action-user&id=<?= $user->id ?>" class="btn btn-sm btn-success">Update</a></td>
                                            <td><button type="button" class="btn btn-sm btn-danger" data-id="<?= $user->id ?>">Delete</button></td>
                                        </tr>
                                    <?php endforeach;
                                else : ?>
                                    <tr>
                                        <th scope="row" colspan="7">We dont have any user!</th>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                if (count($users) >= 5) :
                ?>
                    <div class="row">
                        <div class="col-4 mx-auto">
                            <nav aria-label="...">
                                <ul class="pagination" id="userPagination">
                                    <?php
                                    $userPages = getPagesOfUsers();
                                    for ($i = 0; $i < $userPages; $i++) :
                                        if ($i == 0) :
                                    ?>
                                            <li class="page-item active"><a class="page-link post-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
                                        <?php
                                        endif;
                                        if ($i != 0) :
                                        ?>
                                            <li class="page-item"><a class="page-link post-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
                                    <?php
                                        endif;
                                    endfor;
                                    ?>

                                </ul>
                            </nav>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>