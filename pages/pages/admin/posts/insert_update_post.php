<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName == "Korisnik") {
        header("Location:index.php?page=login");
    }
} else {
    header("Location:index.php?page=status");
}

?>
<section>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $post = getOneFetchAndCheckData('posts', 'id', $_GET['id'], "fetch");
            $selectedTags = getSelectedTags($post->id);
            $tagsArr = [];
            foreach ($selectedTags as $tagElement) {
                array_push($tagsArr, $tagElement->id);
            }
        }
        ?>
        <div class="row my-5">
            <div class="col-lg-6 mx-auto">
                <form method="POST">
                    <input type="hidden" name="postId" id="postId" value="<?= isset($_GET['id']) ? $post->id : '' ?>">
                    <div class="mb-3">
                        <label for="" class="mb-1">Name:</label>
                        <input type="text" name="postName" id="postName" class="form-control" value="<?= isset($_GET['id']) ? $post->name : '' ?>">
                        <em id="postNameErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">Description:</label>
                        <textarea name="postDescirption" id="postDescription" cols="30" rows="10" class="form-control"><?= isset($_GET['id']) ? $post->description : '' ?></textarea>
                        <em id="postDescErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">Image:</label>
                        <input type="file" name="postImage" id="postImage" class="form-control">
                        <em id="postImageErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">Category:</label>
                        <select name="postCategory" id="postCategory" class="form-control">
                            <option value="0">Choose</option>
                            <?php

                            $categories = getAll('categories');
                            foreach ($categories as $category) :
                            ?>
                                <option value="<?= $category->id ?>" <?php if (isset($_GET['id']) && $post->category_id == $category->id) : ?> selected <?php endif; ?>><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <em id="postCategoryErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">Headings:</label>
                        <select name="postHeading" id="postHeading" class="form-select">
                            <option value="0">Choose</option>
                            <?php
                            $headings = getAll('headings');
                            foreach ($headings as $heading) :
                            ?>
                                <option value="<?= $heading->id ?>" <?php if (isset($_GET['id']) && $post->heading_id == $heading->id) : ?> selected <?php endif; ?>><?= $heading->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <em id="postHeadingErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">
                            Tags:
                        </label>
                        <div class="row">
                            <?php
                            $tags = getAll('tags');
                            foreach ($tags as $tag) :
                            ?>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="<?= $tag->id ?>" id="tag<?= $tag->id ?>" name="postTags" <?php if (isset($tags) && isset($tagsArr) && in_array($tag->id, $tagsArr)) : ?> checked <?php endif ?>>
                                        <label class="form-check-label" for="tag<?= $tag->id ?>">
                                            <?= $tag->name ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <em id="postTagsErrorMessage"></em>
                    </div>
                    <?php

                    if (isset($_GET['id'])) :
                    ?>
                        <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="<?= $post->name ?>" class="img-fluid mb-3">
                    <?php endif; ?>
                    <div class="d-grid"><button class="btn btn-primary" type="button" id="submitPost"><?php if (isset($_GET['id'])) : ?> Update<?php else : ?> Save<?php endif; ?> </button></div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>

</script>