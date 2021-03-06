<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName == "User" || $_SESSION['user']->roleName == "Journalist") {
        header("Location:admin.php?page=status&code=401");
    }
} else {
    header("Location:admin.php?page=status&code=401");
} ?>
<section>
    <?php
    if (isset($_GET['id'])) {
        $category = $_GET['id'];
        $category_data = getOneFetchAndCheckData("categories", 'id', $_GET['id'], "fetch");
    }
    ?>
    <div class="container">
        <div class="row my-5">
            <div class="col-sm-8 col-lg-6 mx-auto">
                <?php if (isset($_GET['id'])) : ?><h1 class="text-center">Update category</h1><?php else : ?> <h1 class="text-center">Create new category</h1><?php endif; ?>
                <div id="showDbResponseErrorMessages"></div>
                <form method="POST">
                    <input type="hidden" name="categoryId" id="categoryId" value="<?= isset($_GET['id']) ? $category_data->id : '' ?>">
                    <div class="mb-3">
                        <label for="" class="mb-1">Name:</label>
                        <input type="text" name="categoryName" id="categoryName" class="form-control" value="<?= isset($_GET['id']) ? $category_data->name : '' ?>">
                        <em id="categoryNameErrorMessage"></em>
                    </div>
                    <div class="d-grid"><button type="button" class="btn btn-primary" id="btnCategory"><?php if (isset($_GET['id'])) : ?> Update<?php else : ?> Save <?php endif; ?></button></div>
                </form>
            </div>
        </div>
    </div>
</section>