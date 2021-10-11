<?php
if (!isset($_SESSION['user']) || ($_SESSION['user'] && $_SESSION['user']->roleName == 'User')) :
?>
    <footer class="mt-auto bg-light">
        <h1 class="text-center">E-news</h1>
        <div class="overflow-hidden ">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <?php
                            $categories = getAll('categories');
                            foreach ($categories as $category) :
                            ?>
                                <li class="nav-item"><a href="index.php?page=news&id=<?= $category->id ?>" class="nav-link"><?= $category->name ?></a></li>
                            <?php endforeach; ?>
                        </ul>

                    </div>
                </div>
            </nav>
        </div>
    </footer>
<?php endif ?>
</body>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/admin.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/logAndReg.js"></script>

</html>