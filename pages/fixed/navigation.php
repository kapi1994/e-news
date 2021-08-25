<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <?php
        if (isset($_SESSION['users']) && $_SESSION['users']->roleName == "Admin") :
        ?>
            <a class="navbar-brand" href="index.php?page=admin_home">E-news</a>
        <?php else : ?>
            <a class="navbar-brand" href="index.php?page=home">E-news</a>
        <?php endif; ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php
                if (isset($_SESSION['users']) && $_SESSION['users']->roleName == "Admin") :
                ?>
                    <li class="nav-item"><a href="index.php?page=categories" class="nav-link">Categories</a></li>
                    <li class="nav-item"><a href="index.php?page=headings" class="nav-link">Headings</a></li>
                    <li class="nav-item"><a href="index.php?page=tags" class="nav-link">Tags</a></li>
                    <li class="nav-item"><a href="index.php?page=posts" class="nav-link">Posts</a></li>
                    <li class="nav-item"><a href="index.php?page=users" class="nav-link">Users</a></li>
                    <?php

                elseif ((isset($_SESSION['users']) && $_SESSION['users']->roleName == "User") || (!isset($_SESSION['users']))) :
                    $categories = getAll('categories');
                    foreach ($categories as $category) : ?>
                        <li class="nav-item"><a href="index.php?page=news&categoryName=<?= $category->name ?>" class="nav-link"><?= $category->name ?></a></li>
                    <?php
                    endforeach; ?>
                    <li class="nav-item"><a href="index.php?page=author" class="nav-link">Author</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php
                if (!isset($_SESSION['users'])) :
                ?>
                    <li class="nav-item"><a href="index.php?page=login" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="index.php?page=register" class="nav-link">Register</a></li>
                <?php else : ?>
                    <li class="nav-item"><a href="models/actions/logout.php" class="nav-link">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>