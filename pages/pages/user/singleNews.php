<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-10 mx-auto">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $post = getAllPosts($_GET['id']);
                    $comments = getComments($post->id);

                    $getPostsWithoutThis = getLastFive($post->id);
                }
                ?>
                <div class="row">
                    <div class="col-lg-8">
                        <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="" class="img-fluid">
                        <div class="d-flex">
                            <p class="text-danger my-3 fs-6"><?= $post->categoryName ?></p><span class="my-3 mx-3 text-muted"><?= date("H:i:s d/m/Y", strtotime($post->created_at)); ?></span>
                        </div>
                        <h1 class="mb-3 fs-2"><?= $post->name ?></h1>
                        <p class="fs-5 text-justify"><?= $post->description ?></p>
                        <?php
                        foreach ($comments as $comment) :
                        ?>
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="float-start">
                                        <h2 class="fs-6 mt-1"><?= $comment->firstName . " " . $comment->lastName ?></h2>
                                    </div>
                                    <div class="float-end">
                                        <span class="text-muted"><?= date("H:i:s d/m/Y", strtotime($comment->created_at)); ?></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text"><?= $comment->text ?></p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-lg-4">
                        <?php
                        foreach ($getPostsWithoutThis as $pGet) :
                        ?>
                            <div class="card mb-1">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <img src="assets/images/posts/thumbnail/<?= $pGet->image_path ?>" alt="<?= $pGet->name ?>" class="img-fluid mt-4">
                                        </div>
                                        <div class="col-8">
                                            <a href="index.php?page=singleNews&id=<?= $pGet->id ?>" class="nav-link text-dark"> <em class="text-muted"><?= $pGet->name ?></em></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-end">
                                        <span class="text-muted"><?= date("H:i:s d/m/Y", strtotime($pGet->created_at)); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>