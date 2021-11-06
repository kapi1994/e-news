<section>
    <div class="container">
        <div class="row my-5">
            <?php
            if (isset($_GET['name'])) {
                $categoryName = $_GET['name'];
                $posts = getPostFromCategory($categoryName);
            } else if (isset($_GET['headingName'])) {
                $headingName = $_GET['headingName'];
                $posts = getHeadingsPosts($headingName);
            } else {
                $tagName = $_GET['tag_id'];
                $posts = getSelectedPosts($tagName);
            }
            foreach ($posts as $post) :

            ?>
                <div class="col-lg-3 my-2">
                    <div class="card">
                        <img src="assets/images/posts/normal/<?= $post->image_path ?>" class="card-img-top" alt="<?= $post->name ?>">
                        <div class="card-body">
                            <a href="index.php?page=singleNews&id=<?= $post->id ?>" class="nav-link text-dark">
                                <h5 class="card-title fs-6"><?= $post->name ?></h5>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>