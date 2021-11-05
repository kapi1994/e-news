<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName != "Admin") {
        header("Location:admin.php?page=status&code=401");
    }
} else {
    header("Location:index.php?page=status&code=401");
} ?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3">
                <div class="d-grid"><a href="admin.php?page=user_action" class="btn btn-primary">Create new user</a></div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-lg-3">
                <div class="mb-2">
                    <input type="text" name="searchUser" id="searchUser" placeholder="Search users" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="">Order by:</label>
                    <select name="orderUserByDate" id="orderUserByDate" class="form-select">
                        <option value="0">Opadajucem</option>
                        <option value="1">Rastucem</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="">Roles:</label>
                    <select name="filterByRole" id="filterByRole" class="form-select">
                        <option value="0">Izaberite</option>
                        <?php
                        $roles = $conn->query('SELECT * FROM roles WHERE name !="Admin" ')->fetchAll();
                        foreach ($roles as $role) :
                        ?>
                            <option value="<?= $role->id ?>"><?= $role->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-lg-9">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">Full name</th>
                                <th scope="row">Email</th>
                                <th scope="row">Role</th>
                                <th scope="row">Created at</th>
                                <th scope="row">Updated at</th>
                                <th scope="row">Update</th>
                                <th scope="row">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="users">
                            <?php
                            $userElements = getNumOfUsers('count');
                            if ($userElements->numberOfUsers > 0) :
                            ?>
                                <?php
                                $rb = 1;

                                $users = userPagination('', '', '');

                                foreach ($users as $user) :
                                ?>
                                    <tr>
                                        <th scope="row"><?= $rb++ ?></th>
                                        <td><?= $user->first_name . " " . $user->last_name ?></td>
                                        <td><?= $user->email ?></td>
                                        <td><?= $user->roleName ?></td>
                                        <td><?= date("H:i:s d/m/Y", strtotime($user->created_at)) ?></td>
                                        <td><?= $user->updated_at != null ? date("H:i:s d/m/Y", strtotime($user->updated_at)) : '/' ?></td>
                                        <td><a href="admin.php?page=user_action&id=<?= $user->id ?>" class="btn btn-sm btn-success">Update</a></td>
                                        <td><button type="button" class="btn btn-danger btn-sm" data-id="<?= $user->id ?>">Delete</button></td>
                                    </tr>
                                <?php endforeach;
                            else : ?>
                                <tr>
                                    <th colspan='8' class="text-center">We dont have any user at this moment</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php
                    $userPagination = getNumOfUsers('count');
                    if ($userPagination->numberOfUsers > 5) :
                    ?>
                        <div class="row mt-3">
                            <div class="col-4 mx-auto">
                                <nav aria-label="...">
                                    <ul class="pagination" id="tagPagination">
                                        <?php
                                        $userPages = getNumOfUsers('pagination');
                                        for ($i = 0; $i < $userPages; $i++) :
                                            if ($i == 0) :
                                        ?>
                                                <li class="page-item active"><a class="page-link user-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
                                            <?php
                                            endif;
                                            if ($i != 0) :
                                            ?>
                                                <li class="page-item"><a class="page-link user-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
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
    </div>
</section>