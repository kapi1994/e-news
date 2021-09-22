<section>
    <?php
    if (isset($_GET['id'])) {
        $post = getAllPosts($_GET['id']);
        $comments = getComments($post->id, "");
    }
    ?>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-6">
                <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="<?= $post->name ?>" class="img-fluid">
                <div class="d-flex mt-3">
                    <p class="text-danger"><?= $post->categoryName ?></p>
                    <em class="ms-3 text-muted"><?= date("H:i:s d/m/Y", strtotime($post->created_at)) ?></em>
                </div>
                <h1 class="fs-4 my-3"><?= $post->name ?></h1>
                <p class="text-justify">
                    <?= $post->description ?>
                </p>
            </div>
            <div class="col-lg-6">
                <?php

                foreach ($comments as $comment) :
                ?>
                    <div class="card my-1">
                        <div class="card-header">
                            <div class="ms-2 float-start">
                                <?= $comment->firstName . ' ' . $comment->lastName ?>
                            </div>
                            <div class="float-end me-2 text-muted fst-italic">
                                <?= date("H:i:s d/m/Y", strtotime($comment->created_at)) ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= $comment->text ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>