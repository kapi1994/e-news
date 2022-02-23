<main class="container">
    <?php
    $last_one = lastOne();
    $last_except_last_one = exceptLastOne($last_one->id);
    ?>
    <div class="row my-3">
        <div class="col col-lg-8">
            <div class="card">
                <img class="card-img-top" src="assets/images/posts/normal/<?= $last_one->image_path ?>" alt="Card image cap">
                <div class="card-body">
                    <a href="index.php?page=singleNews&id=<?= $last_one->id ?>" class="text-dark text-decoration-none">
                        <h1 class="fs-3"><?= $last_one->name ?></h1>
                    </a>
                    <span class="text-dark fw-bold d-inline-block my-2">
                        <?= $last_one->categoryName ?>
                    </span> | <span><?= date("H:i", strtotime($last_one->created_at)) ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <?php
            foreach ($last_except_last_one as $post) :
            ?>
                <div class="card">
                    <div class="row">
                        <div class="col-8">
                            <img class="img-fluid image-small" src="assets/images/posts/thumbnail/<?= $post->image_path ?>" alt="Card image cap">
                        </div>
                        <div class="col-4">
                            <a href="index.php?page=singleNews&id=<?= $last_one->id ?>" class="text-dark text-decoration-none">
                                <h2 class="fs-5"><?= $last_one->name ?></h2>
                            </a>
                            <span class="text-dark fw-bold d-inline-block my-2">
                                <?= $last_one->categoryName ?>
                            </span> | <span><?= date("H:i", strtotime($last_one->created_at)) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row my-3 ">
        <?php
        $categories = getAll('categories');
        foreach ($categories as $category) :
            $posts = getPostsFilteredByCategory($category->id);
        ?>
            <h2 class="fs-4 mt-2"><?= $category->name ?></h2>
            <hr>
            <div class="row">
                <?php

                foreach ($posts as $post) :
                ?>

                    <div class=" col-6 col-lg-3 my-1">
                        <div class="card box h-100 d-flex flex-column">
                            <img src="assets/images/posts/thumbnail/<?= $post->image_path ?>" class="img-fluid img-resize" alt="...">
                            <div class="card-body">
                                <a href="index.php?page=singleNews&id=<?= $post->id ?>" class="text-center text-dark text-decoration-none">
                                    <h5 class="card-title"><?= $post->name ?></h5>
                                </a>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between"><span class="fw-bold"><?= $post->headingName ?></span><span><?= date('H:i', strtotime($post->created_at)) ?></span></div>
                            </div>
                        </div>

                    </div>
                <?php
                endforeach; ?>
            </div>
        <?php
        endforeach; ?>
    </div>
</main>