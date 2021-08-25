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
            <div class="col-6 mx-auto">
                <div id="showDbResponseErrorMessages"></div>
                <?php
                if (isset($_GET['id'])) {
                    $category = getDataWithFetch('categories', 'id', $_GET['id']);
                }
                ?>
                <form action="#" method="#">
                    <input type="hidden" name="categoryId" id="categoryId" value="<?= isset($category)  ? $category->id : '' ?>">
                    <div class="mb-3">
                        <label for="categoryName">Name:</label>
                        <input type="text" name="categoryName" id="categoryName" class="form-control" value="<?= isset($category) ? $category->name : '' ?>">
                        <em id="categoryNameErrorMessage"></em>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="button" id="btnCategory"><?= isset($_GET['id']) ? "Update" : "Save" ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>