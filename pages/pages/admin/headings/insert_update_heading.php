<section>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $heading = getOneFetchAndCheckData('headings', 'id', $_GET['id'], 'fetch');
        }
        ?>
        <row class="my-5">
            <div class="col-lg-6 mx-auto">
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
                        <select name="headingCategory" id="headingCategory" class="form-select">
                            <option value="0">Choose</option>
                            <?php
                            $categories = getAll('categories');
                            foreach ($categories as $category) :
                            ?>
                                <option value="<?= $category->id ?>" <?php if (isset($_GET['id']) && $heading->category_id == $category->id) : ?> selected <?php endif; ?>><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <em id="headingCategoryErrorMessage"></em>
                    </div>
                    <div class="d-grid"><button class="btn btn-primary" id="btnHeading"><?php if (isset($_GET['id'])) : ?> Update <?php else : ?> Save<?php endif; ?> </button></div>
                </form>
            </div>
        </row>
    </div>
</section>