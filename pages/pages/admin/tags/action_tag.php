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
            <?php
            if (isset($_GET['id'])) {
                $tag = getDataWithFetch('tags', 'id', $_GET['id']);
            }
            ?>
            <div class="col-6 mx-auto">
                <div id="crudShowErrorMessages"></div>
                <form method="POST">
                    <input type="hidden" name="tagId" id="tagId" value="<?= isset($_GET['id']) ? $tag->id : '' ?> ">
                    <div class="mb-3">
                        <label for="tagName">Name:</label>
                        <input type="text" name="tagName" id="tagName" class="form-control" value="<?= isset($tag) ? $tag->name : '' ?>">
                        <em id="tagNameErrorMessage"></em>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" id="btnTag" type='button'><?= isset($_GET['id']) ? "Update" : "Save" ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </?>