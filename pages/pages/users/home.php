<section>

    <div class="container">

        <div class="row my-3">
            <?php
            $posts = getAll('posts');
            ?>

            <div class="row">
                <?php foreach ($posts as $post) : ?>
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-2">
                        <div class="card">
                            <div class="card-body">
                                <picture>
                                    <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="<?= $post->name ?>" class="img-fluid">
                                </picture>
                            </div>
                            <div class="card-footer">
                                <h2 class="fs-5"><a href="index.php?page=single-post&id=<?= $post->id ?>" class="nav-link text-dark text-uppercase"><?= $post->name ?></a></h2>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>