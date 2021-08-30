<?php
if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}
$categories = getAll('categories');
$tags = getAll('tags');
?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-6 mx-auto">
                <div id="crudPostErrorMessages"></div>
                <?php
                if (isset($_GET['id'])) {
                    $post = getDataWithFetch('posts', 'id', $_GET['id']);
                    $tag_arr = [];
                    $post_tag = getPostTag($post->id);
                    foreach ($post_tag as $pt) {
                        array_push($tag_arr, $pt->id);
                    }
                }
                ?>
                <form action="#" method="#">

                    <input type="hidden" name="postId" id="postId" value="<?= isset($post) ? $post->id : '' ?>">

                    <div class="mb-3">
                        <label for="postName" class="mb-1">Name</label>
                        <input type="text" name="postName" id="postName" class="form-control" value="<?= isset($post) ? $post->name : "" ?>">
                        <em id="postNameErrrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="postDescription" class="mb-1">Description:</label>
                        <textarea name="postDescription" id="postDescription" cols="30" rows="10" class="form-control"><?= isset($post) ? $post->description : '' ?></textarea>
                        <em id="postDescErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="postImage" class="mb-1">Image:</label>
                        <input type="file" name="postImage" id="postImage" class="form-control">
                        <em id="postImageErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="postCategory" class="mb-1">Category:</label>
                        <select name="postCategory" id="postCategory" class="form-select">
                            <option value="0">Choose</option>
                            <?php
                            foreach ($categories as $category) :
                            ?>
                                <option value="<?= $category->id ?>" <?php if (isset($categories) && isset($post) && $category->id == $post->category_id) : ?> selected <?php else : ?> <?php endif; ?>><?= $category->name ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                        <em id="postCategoryErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="postHeading" class="mb-1">Heading:</label>
                        <select name="postHeading" id="postHeading" class="form-select">
                            <option value="0">Choose</option>
                            <?php
                            $headings = getAll('headings');
                            foreach ($headings as $heading) :
                            ?>
                                <option value="<?= $heading->id ?>" <?php if (isset($headings) && isset($post) && $heading->id == $post->heading_id) : ?> selected <?php else : ?> <?php endif; ?>><?= $heading->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <em id="postHeadingErrorMessage"></em>
                    </div>
                    <div class="mb-3">
                        <label for="postTags" class="mb-3">Tags:</label>
                        <?php
                        foreach ($tags as $tag) :
                        ?>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $tag->id ?>" id="tag_<?= $tag->id ?>" name="postTags" <?php if (isset($tags) && isset($tag_arr) && in_array($tag->id, $tag_arr)) : ?> checked <?php endif ?>>
                                    <label class="form-check-label" for="tag_<?= $tag->id ?>">
                                        <?= $tag->name ?>
                                    </label>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                        <em id="postTagsErrorMessage"></em>
                    </div>
                    <?php
                    if (isset($_GET['id'])) :
                    ?>
                        <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="" class="img-fluid mb-2">
                    <?php endif ?>
                    <div class="d-grid"><button class="btn btn-primary" type="button" id="submitPost">Submit</button></div>
                </form>
            </div>
        </div>
    </div>
</section>