<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-6">
                <div class="d-grid"><button class="btn btn-primary">Jedan</button></div>
            </div>
            <div class="col-lg-6">
                <div class="d-grid"><button class="btn btn-primary">Dva</button></div>
            </div>
        </div>
        <div class="row">
            <?php
            $posts = $conn->query("SELECT * FROM posts ORDER BY created_at LIMIT 4")->fetchAll();
            ?>
            <h1 class="my-2 fs-3">By category</h1>
            <div class="row">
                <?php foreach ($posts as $post) : ?>
                    <div class="col-lg-3 d-flex align-items-stretch">
                        <div class="card">
                            <div class="card-body">
                                <picture>
                                    <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="<?= $post->name ?>" class="img-fluid">
                                </picture>
                            </div>
                            <div class="card-footer">
                                <h2 class="fs-5"><a href="index.php?page=single&id=<?= $post->id ?>" class="nav-link text-dark text-uppercase"><?= $post->name ?></a></h2>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>