<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName == "User") {
        header("Location:admin.php?page=status&code=401");
    }
} else {
    header("Location:admin.php?page=status&code=401");
} ?>
<section>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $heading = getOneFetchAndCheckData('headings', 'id', $_GET['id'], 'fetch');
        }
        ?>
        <div class="my-5">
            <div class="col-lg-6 mx-auto">
                <?php if (isset($_GET['id'])) : ?> <h1 class="text-center">Update heading</h1><?php else : ?><h1 class="text-center">Add new heading</h1><?php endif; ?>
                <div id="showDbResponseErrorMessages"></div>
                <form method="POST">
                    <input type="hidden" name="headingId" id="headingId" value="<?= isset($_GET['id']) ? $heading->id : "" ?>">
                    <div class="mb-3">
                        <label for="" class="mb-1">Name</label>
                        <input type="text" name="headingName" id="headingName" class="form-control" value="<?= isset($_GET['id']) ? $heading->name : '' ?>">
                        <em id="headingNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">Categories:</label>
                        <select name="headingCategory" id="headingCategory" class="form-select" <?php
                                                                                                if ($_SESSION['user']->roleName == "Journalist") :
                                                                                                ?> disabled<?php endif; ?>>
                            <option value="0">Choose</option>
                            <?php
                            $categories = getAll('categories');
                            foreach ($categories as $category) :

                            ?>

                                <option value="<?= $category->id ?>" <?php if (isset($_GET['id']) && $heading->category_id == $category->id) : ?> selected <?php elseif ($_SESSION['user']->roleName == "Journalist" && $category->id == $_SESSION['user']->category_id) : ?> selected <?php endif; ?>><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <em id="headingCategoryErrorMessage"></em>
                    </div>
                    <div class="d-grid"><button class="btn btn-primary" id="btnHeading"><?php if (isset($_GET['id'])) : ?> Update <?php else : ?> Save<?php endif; ?> </button></div>
                </form>
            </div>
        </div>
    </div>
</section>