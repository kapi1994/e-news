<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <?php if (isset($_SESSION['user']) && $_SESSION['user']->roleName != 'User') :
        ?>
            <a class="navbar-brand fw-bold fst-italic" href="admin.php">E-news</a>
        <?php else : ?>
            <a class="navbar-brand fw-bold fst-italic" href="index.php">E-news</a>
        <?php endif; ?>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php
                if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->roleName == "User")) :
                    $userMenus = getAll('categories');


                ?><?php
                    foreach ($userMenus as $meni) :
                    ?>
                <li class="nav-item"><a href="index.php?page=news&name=<?= $meni->name ?>" class="nav-link <?php if (isset($_GET['name']) && $_GET['name'] == $meni->name) : ?>fw-bold active<?php endif; ?>"><?= $meni->name ?></a></li>
            <?php endforeach; ?>
            <li class=" nav-item"><a href="index.php?page=author" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'author') : ?> fw-bold active<?php endif; ?>">Author</a></li>
            <li class="nav-item"><a href="index.php?page=contact" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'contact') : ?> fw-bold active<?php endif; ?>">Contact</a></li>
        <?php endif;
        ?>
        <?php
        if (isset($_SESSION['user'])) :
            if ($_SESSION['user']->roleName == "Journalist" || $_SESSION['user']->roleName == "Admin") :
        ?>
                <li class="nav-item"><a href="admin.php?page=categories" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'categories') : ?> fw-bold active<?php endif; ?>">Categories</a></li>
                <li class="nav-item"><a href="admin.php?page=headings" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'headings') : ?> fw-bold active<?php endif; ?>">Headings</a></li>
                <li class="nav-item"><a href="admin.php?page=tags" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'tags') : ?> fw-bold active<?php endif; ?>">Tags</a></li>
                <?php if ($_SESSION['user']->roleName == "Admin") : ?>
                    <li class="nav-item"><a href="admin.php?page=users" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'users') : ?> fw-bold active<?php endif; ?>">Users</a></li>
                    <li class="nav-item"><a href="admin.php?page=tasks" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'tasks') : ?> fw-bold active<?php endif; ?>">Tasks</a></li>
                <?php endif; ?>
                <li class="nav-item"><a href="admin.php?page=posts" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'posts') : ?> fw-bold active<?php endif; ?>">Posts</a></li>
        <?php
            endif;
        endif; ?>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php
                if (!isset($_SESSION['user'])) :
                ?>
                    <li class="nav-item"><a href="index.php?page=login" class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 'login') : ?> fw-bold active<?php endif; ?>">Login</a></li>
                    <li class="nav-item"><a href="index.php?page=register" class="nav-link<?php if (isset($_GET['page']) && $_GET['page'] == 'register') : ?> fw-bold active<?php endif; ?>">Register</a></li>
                <?php else : ?>
                    <li class="nav-item"><a href="models/action/logout.php" class="nav-link">Logout</a></li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>