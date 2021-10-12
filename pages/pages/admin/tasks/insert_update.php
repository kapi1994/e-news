<main class="container">
    <div class="row my-3">
        <div class="col-lg-6 mx-auto">
            <form method="POST">
                <input type="hidden" name="taskId" id="taskId" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $task = $conn->query("SELECT * FROM tasks t JOIN users u ON t.user_id = u.id WHERE t.id = '$id'")->fetch();
                }
                ?>
                <div class="mb-3">
                    <label for="">Description:</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control">
                        <?= isset($_GET['id']) ? $task->description : '' ?>
                    </textarea>
                    <em id="validationErrorTaskDescription"></em>
                </div>
                <div class="mb-3">
                    <?php
                    $users = $conn->query("SELECT u.id, u.first_name, u.last_name FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name = 'Urednik'")->fetchAll();

                    ?>
                    <label for="">Za koga:</label>
                    <select name="ddlUser" id="ddlUser" class="form-select">
                        <option value="0">Choose</option>
                        <?php
                        foreach ($users as $user) :

                        ?>
                            <option value="<?= $user->id ?>" <?php if (isset($_GET['id']) && $task->user_id = $user->id) : ?> selected<?php endif; ?>><?= $user->first_name . ' ' . $user->last_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <em id="validationErrorTaskUser"></em>
                </div>
                <div class="d-grid"><button class="btn btn-primary" id="submitTasks" type="button">Submit</button></div>
            </form>
        </div>
    </div>
</main>
<script>
    CKEDITOR.replace('description');
</script>