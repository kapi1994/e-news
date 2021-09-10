<section>
    <?php
    if (isset($_GET['id'])) {
        $tag = getOneFetchAndCheckData('tags', 'id', $_GET['id'], 'fetch');
    }
    ?>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-6 mx-auto">
                <form>
                    <input type="hidden" name="TagId" class="form-control" id="TagId" value="<?= isset($_GET['id']) ? $tag->id : '' ?>">
                    <div class="mb-3">
                        <label for="" class="mb-1">Name:</label>
                        <input type="text" name="tagName" id="tagName" class="form-control" value="<?= isset($_GET['id']) ? $tag->name : '' ?>">
                        <em id="tagNameErrorMessage"></em>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" id=""><?php if (isset($_GET['id'])) : ?> Update <?php else : ?> Save <?php endif; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>