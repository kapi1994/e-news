<section>
    <div class="container">
        <div class="row my-5">
            <?php
            if (isset($_GET['id'])) {
                $posts = getOneFetchAndCheckData('posts', 'category_id', $_GET['id'], "fetch");
            }
            foreach ($posts as $post) :

            ?>
                <div class="col-lg-3">
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