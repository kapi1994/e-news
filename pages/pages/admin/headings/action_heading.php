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
                <em id="crudResponseErrorsMessages"></em>
                <?php
                if (isset($_GET['id'])) {
                    $heading = getDataWithFetch('headings', 'id', $_GET['id']);
                }
                ?>
                <form action="#" method="#">
                    <input type="hidden" name="headingId" id="headingId" value="<?= isset($heading) ? $heading->id : '' ?>">
                    <div class="mb-3">
                        <label for="headingName">Name:</label>
                        <input type="text" name="headingName" id="headingName" class="form-control" value="<?= isset($heading) ? $heading->name : '' ?>">
                        <em id="headingNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="headingCategory">Category:</label>
                        <select name="headingCategory" id="headingCategory" class="form-select">
                            <option value="0">Choose</option>
                            <?php
                            $categories = getAll('categories');
                            foreach ($categories as $category) :
                            ?>
                                <option value="<?= $category->id ?>" <?php if (isset($category) && isset($heading) && $category->id == $heading->category_id) : ?> selected <?php else : ?> <?php endif; ?>><?= $category->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <em id="headingCategoryErrorMessage"></em>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="button" id="btnHeading"><?= isset($_GET['id']) ? "Update" : "Save" ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>