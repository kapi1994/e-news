<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName == "User" && $_SESSION['user']->roleName == "Journalist") {
        header("Location:index.php?page=status");
    }
} else {
    header("Location:index.php?page=status");
} ?>
<main class="container">
    <div class="row my-3">
        <?php if (isset($_GET['id'])) : ?><h1 class="text-center">Update task</h1><?php else : ?> <h1 class="text-center">Create new task</h1> <?php endif; ?>
        <div class="col-lg-6 mx-auto">
            <form method="POST">
                <input type="hidden" name="taskId" id="taskId" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
                <?php
                if (isset($_GET['id'])) {

                    $task = getOneFetchAndCheckData('tasks', 'id', $_GET['id'], 'fetch');
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
                    $users = getUsersWithRoleOfJournalist();

                    ?>
                    <label for="">Za koga:</label>
                    <select name="ddlUser" id="ddlUser" class="form-select">
                        <option value="0">Choose</option>
                        <?php
                        foreach ($users as $user) :

                        ?>
                            <option value="<?= $user->id ?>" <?php if (isset($_GET['id']) && $task->user_id == $user->id) : ?> selected<?php endif; ?>><?= $user->first_name . ' ' . $user->last_name ?></option>
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