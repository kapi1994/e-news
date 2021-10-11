<?php
if (isset($_SESSION['user'])) {
    // var_dump($_SESSION['user']);
    if ($_SESSION['user']->roleName == "Korisnik") {
        header("Location:index.php?page=401");
    }
} else {
    header("Location:index.php?page=status");
}
?>
<main class="container">
    <div class="row my-3">
        <?php
        if (isset($_SESSION['user'])) :
            $user = $_SESSION['user'];
            if ($user->roleName == "Admin") :
        ?>
                Admin
            <?php else : ?>
                <h1 class="my-3">Zadaci</h1>
                <?php
                $tasks = $conn->query("SELECT * FROM tasks WHERE user_id = '$user->id' AND active=0")->fetchAll();

                foreach ($tasks as $task) :
                ?>
                    <div class="alert alert-secondary" role="alert">
                        <p class="fw-bold float-start"><?= $task->description ?></p>
                        <div class="float-end">
                            <div class="form-check float-end">
                                <input class="form-check-input" type="checkbox" value="<?= $task->id ?>" id="task<?= $task->id ?>">
                                <label class="form-check-label" for="task<?= $task->id ?>">
                                    Cekirati ukoliko je zavrsen
                                </label>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif; ?>
        <?php endif; ?>
    </div>
</main>