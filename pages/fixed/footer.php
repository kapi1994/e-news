<footer class="mt-auto bg-light">
    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto">
                <?php
                if (isset($_SESSION['users']) && $_SESSION['users']->roleName == "User") :
                ?>
                    <div class="row my-2">
                        <div class="col-4">
                            <h2>E-news</h2>
                        </div>
                        <div class="col-6 d-flex">
                            <a href="data/logs.txt" class="nav-link">Dokumentacija</a>
                            <a href="#" class="nav-link">Sitemap</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row pb-2">
            <p class="text-center">All right reserved</p>
        </div>

    </div>

</footer>
<script src="assets/js/jquery.js"></script>

<script src="assets/js/logAndReg.js"></script>


<script src="assets/js/main.js"></script>


<?php if (isset($_SESSION['users']) && $_SESSION['users']->roleName = "Admin") : ?>
    <script src="assets/js/adminChart.js"></script>
<?php endif; ?>
<script src="assets/js/admin.js"></script>
</body>

</html>