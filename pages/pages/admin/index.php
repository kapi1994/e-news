<?php
if (isset($_SESSION['user'])) {

    if ($_SESSION['user']->roleName == "User") {
        header("Location:index.php?page=status&code=401");
    }
} else {
    header("Location:index.php?page=status&code=401");
}
?>
<main class="container">
    <div class="row my-3">
        <?php
        if (isset($_SESSION['user'])) :
            $user = $_SESSION['user'];
            if ($user->roleName == "Admin") :
        ?>
                <div class="col-md-6 col-lg-3 mb-1 mt-lg-0">
                    <div class="d-grid">

                        <div class="card-title" id="viewsTotal"></div>
                        <div class="card">
                            <canvas id="ChartTotal"></canvas>
                        </div>
                        <table class='table mt-2'>
                            <tbody id="Total"></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-1 mt-lg-0">
                    <div class="d-grid">

                        <div class="card-title" id="viewsH24"></div>
                        <div class="card">
                            <canvas id="ChartH24"></canvas>
                        </div>
                        <table class='table mt-2'>
                            <tbody id="H24"></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-2 ">
                    <div class="card text-center  text-white mb-3">
                        <!-- numbar of posts -->
                        <div class="card-body">
                            <h3 class="text-dark fw-bold">Total number of posts</h3>
                            <h4 class="display-4 text-dark" id="totalNumberOfPosts">
                                <i class="fas fa-pencil-alt"></i>6
                            </h4>
                            <a href="admin.php?page=users" class="btn btn-outline-dark btn-sm">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 ">

                    <div class="card text-center  text-white mb-3">
                        <!-- numbar of posts -->
                        <div class="card-body">
                            <h3 class="text-dark fw-bold">Total number of users</h3>
                            <h4 class="display-4 text-dark" id="totalNumberOfUsers">
                                <i class="fas fa-pencil-alt"></i>
                            </h4>
                            <a href="admin.php?page=users" class="btn btn-outline-dark btn-sm">View</a>
                        </div>


                    </div>
                </div>
                <div class="col-lg-2 ">

                    <div class="card text-center  text-white mb-3">
                        <!-- numbar of posts -->
                        <div class="card-body">
                            <h3 class="text-dark fw-bold">Total number of users</h3>
                            <h4 class="display-4 text-dark" id="loggedUsersForThisDay">
                                <i class="fas fa-pencil-alt"></i>
                            </h4>

                        </div>
                    </div>


                </div>

            <?php else : ?>
                <h1 class="my-3">Today tasks</h1>
                <?php
                $tasks = getAllTasks($user->id);

                foreach ($tasks as $task) :
                ?>
                    <div class="alert alert-secondary" role="alert">
                        <p class="float-start"><?= $task->description ?></p>
                    </div>
            <?php
                endforeach;
            endif; ?>
        <?php endif; ?>
    </div>
</main>