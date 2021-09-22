<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php
                if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->roleName == "User")) :
                    $userMenus = getAll('categories');
                    foreach ($userMenus as $meni) :
                ?>
                        <li class="nav-item"><a href="index.php?page=news&id=<?= $meni->id ?>" class="nav-link"><?= $meni->name ?></a></li>
                <?php endforeach;
                endif;
                ?>
                <?php
                if (isset($_SESSION['user'])) :
                    if ($_SESSION['user']->roleName == "Urednik" || $_SESSION['user']->roleName == "Admin") :
                ?>
                        <li class="nav-item"><a href="index.php?page=categories" class="nav-link">Categories</a></li>
                        <li class="nav-item"><a href="index.php?page=headings" class="nav-link">Headings</a></li>
                        <li class="nav-item"><a href="index.php?page=tags" class="nav-link">Tags</a></li>
                        <?php if ($_SESSION['user']->roleName == "Admin") : ?>
                            <li class="nav-item"><a href="index.php?page=users" class="nav-link">Users</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a href="index.php?page=posts" class="nav-link">Posts</a></li>
                <?php
                    endif;
                endif; ?>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php
                if (!isset($_SESSION['user'])) :
                ?>
                    <li class="nav-item"><a href="index.php?page=login" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="index.php?page=register" class="nav-link">Register</a></li>
                <?php else : ?>
                    <li class="nav-item"><a href="models/action/logout.php" class="nav-link">Logout</a></li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>