<?php
if (isset($_GET['categoryName'])) {
    $name = $_GET['categoryName'];
    $getCategory = getDataWithFetch('categories', 'name', $name);
    $posts = getDataWithFetch('posts', 'category_id', $getCategory->id);
    var_dump($posts);
}
if (isset($_GET['tag_id'])) {
    // $posts = getDataWithFetch()
}
?>
<section>
    <div class="container">
        <div class="row my-3 mx-auto">
            <div class="col-lg-8">
                <div class="row">
                    <?php
                    if (count($posts) > 1) :

                        foreach ($posts as $post) :

                    ?>

                            <div class="col-sm col-md-6 col-lg-4 mt-1 d-flex align-items-stretch">
                                <div class=" ">
                                    <img src="assets/images/posts/normal/<?= $post->image_path ?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="index.php?page=single-post&id=<?= $post->id ?>" class="nav-link"><?= $post->name ?></a></h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    else :
                        ?>
                        <div class="col-sm col-md-6 col-lg-4 mt-1 d-flex align-items-stretch">
                            <div class=" ">
                                <img src="assets/images/posts/normal/<?= $post->image_path ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="index.php?page=single-post&id=<?= $post->id ?>" class="nav-link"><?= $post->name ?></a></h5>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <?php
                $latesetNews = $conn->query("SELECT * FROM posts ORDER BY created_at DESC limit 3")->fetchAll();
                foreach ($latesetNews as $lNews) :
                ?>
                    <div class="row">
                        <div class="col">
                            <div class="row my-2">
                                <div class="col-4">
                                    <picture><img src="assets/images/posts/thumbnail/<?= $lNews->image_path ?>" alt="<?= $lNews->name ?>" class="img-fluid"></picture>
                                </div>
                                <div class="col-8">
                                    <a href="index.php?page=single-post&id=<?= $lNews->id ?>" class="nav-link text-dark">
                                        <h3 class="fs-5"><?= $lNews->name ?></h3>
                                    </a>
                                    <p class="text-muted"><?= date("H:i:s d-m-Y", strtotime($lNews->created_at)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                ?>
            </div>
        </div>
    </div>
</section>