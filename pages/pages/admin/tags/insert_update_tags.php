<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName  == "User") {
        header("Location:admin.php?page=status&code=401");
    }
} else {
    header("Location:admin.php?page=status&code=401");
}

?>
<section>

    <?php
    if (isset($_GET['id'])) {
        $tag = getOneFetchAndCheckData('tags', 'id', $_GET['id'], 'fetch');
    }
    ?>
    <div class="container">
        <div class="row my-5">
            <?php if (isset($_GET['id'])) : ?><h1 class="text-center">Update tag</h1><?php else : ?> <h1 class="text-center">Create new tag</h1><?php endif; ?>

            <div id="showDbTagsErrorMessages"></div>
            <div class="col-lg-6 mx-auto">
                <form method="POST">
                    <input type="hidden" name="TagId" class="form-control" id="TagId" value="<?= isset($_GET['id']) ? $tag->id : '' ?>">
                    <div class="mb-3">
                        <label for="" class="mb-1">Name:</label>
                        <input type="text" name="tagName" id="tagName" class="form-control" value="<?= isset($_GET['id']) ? $tag->name : '' ?>">
                        <em id="tagNameErrorMessage"></em>
                    </div>

                    <div class="mb-3">
                        <label for="">Heading:</label>

                        <?php
                        if (isset($_GET['id'])) {
                            $selectedHeadings = getTagHeadings($_GET['id']);
                        }

                        if ($_SESSION['user']->roleName == "Journalist") {
                            $category_id = $_SESSION['user']->category_id;
                            $headings = getHeadingByCategoryId($category_id);
                        } else {
                            $headings = getAll('headings');
                        } ?>
                        <div class="row text-center">
                            <?php
                            foreach ($headings as $heading) :
                            ?>
                                <div class="col-xs-12 col-6 col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="<?= $heading->id ?>" id="heading<?= $heading->id ?>" name="tagHeadings" <?php if (isset($headings) && isset($selectedHeadings) && in_array($heading->id, $selectedHeadings)) : ?> checked <?php endif; ?>>
                                        <label class="form-check-label" for="heading<?= $heading->id ?>">
                                            <?= $heading->name ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <em id="tagHeading"></em>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" id="btnTag"><?php if (isset($_GET['id'])) : ?> Update <?php else : ?> Save <?php endif; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>