<?php
if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}


?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h1 class="fs-5" id="viewsTotal"></h1>
                        <canvas id="chartTotal"></canvas>
                    </div>
                    <div class="card-footer">
                        <table class="table">
                            <tbody id="Total"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h1 class="fs-5" id="views24H"></h1>
                        <canvas id="chart24h"></canvas>
                    </div>
                    <div class="card-footer">
                        <table class="table">
                            <tbody id="24h"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mt-sm-2 mt-md-0 mt-lg-0">
                <div class="card">
                    <div class="card-header">
                        <h1 class="fts-bold fs-3">
                            Registred users:
                        </h1>
                    </div>
                    <div class="card-body">
                        <h2 class="fts-bold fs-1 text-center" id="registeredUsers">6</h2>
                    </div>
                </div>

            </div>
            <div class="col-lg-3 mt-sm-2 mt-md-0 mt-lg-0">
                <div class="card">
                    <div class="card-header">
                        <h1 class="fts-bold fs-3">
                            Today logins:
                        </h1>
                    </div>
                    <div class="card-body">
                        <h2 class="fts-bold fs-1 text-center" id="todayLogins">12</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script>
<scrip src="assets/js/adminChart.js">
    </script>