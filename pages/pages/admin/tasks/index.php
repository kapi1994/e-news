<main class="container">
    <div class="row my-3">
        <div class="col-lg-3">
            <div class="d-grid"><a href="index.php?page=insert_update_task" class="btn btn-primary">Create new task</a></div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="table-responsive-sm table-responsive-md">
            <table class="table text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Naziv zadatka</th>
                        <th>Za koga</th>
                        <th>Datum kreiranja</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tasks = $conn->query("SELECT t.* ,u.first_name, u.last_name FROM tasks t JOIN users u ON t.user_id = u.id")->fetchAll();
                    $rb  = 1;

                    foreach ($tasks as $task) :

                    ?>
                        <tr>
                            <th><?= $rb++ ?></th>
                            <td><?= $task->description ?></td>
                            <td><?= $task->first_name . ' ' . $task->last_name ?></td>
                            <td><?= $task->created_at ?></td>
                            <td><a href="index.php?page=insert_update_task&id=1" class="btn btn-sm btn-success" data-id="<?= $task->id ?>">Update</td>
                            <td><button type="button" class="btn btn-sm btn-danger" data-id="<?= $task->id ?>">Delete</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>