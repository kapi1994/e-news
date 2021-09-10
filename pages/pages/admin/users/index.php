<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3">
                <div class="d-grid"><a href="index.php?page=user_action" class="btn btn-primary">Create new user</a></div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-lg-3">
                <div class="mb-2">
                    <input type="text" name="" id="" placeholder="Search users" class="form-control">
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
                        <tbody>
                            <?php
                            $rb = 1;

                            $users = getAllUsers();

                            foreach ($users as $user) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $rb++ ?></th>
                                    <td><?= $user->first_name . " " . $user->last_name ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->roleName ?></td>
                                    <td><?= date("H:i:s d/m/Y", strtotime($user->created_at)) ?></td>
                                    <td><?= $user->updated_at != null ? date("H:i:s d/m/Y", strtotime($user->updated_at)) : '/' ?></td>
                                    <td><a href="index.php?page=user_action&id=<?= $user->id ?>" class="btn btn-sm btn-success">Update</a></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" data-id="<?= $user->id ?>">Delete</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>