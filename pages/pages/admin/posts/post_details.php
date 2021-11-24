<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName == "User") {
        header("Location:admin.php?page=status&code=401");
    }
} else {
    header("Location:admin.php?page=status&code=401");
} ?>
<section>
    <?php
    if (isset($_GET['id'])) {
        $post = getAllPosts($_GET['id']);
        $comments = getComments($post->id, "");
        $postTags = getSelectedTags($_GET['id']);
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
                <div class="row">
                    <?php foreach ($postTags as $postTag) :
                    ?>
                        <div class="col-3">
                            <div class="d-grid"><button class="btn btn-outline-dark btn-sm"><?= $postTag->name ?></button></div>
                        </div>
                    <?php endforeach; ?>
                </div>
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

                        <div class="card-footer">
                            <div class="float-end gap-2">
                                <button class="btn btn-outline-primary">Show more</button>
                                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Show reactions
                                </button>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>