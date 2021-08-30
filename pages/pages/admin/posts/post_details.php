<?php
if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}
?>
<section>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $id =  $_GET['id'];
            $post = $conn->query("SELECT p.*, c.name as categoryName FROM posts p JOIN categories c ON p.category_id = c.id WHERE p.id = $id")->fetch();
            $post_tag = getPostTag($post->id);
            // var_dump($post_tag);
            // $postTag_arr = [];
        } ?>

        <div class="row my-3">

            <div class="col-lg-10 mx-auto">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="" class="img-fluid mb-3">
                        <small class="text-danger text-uppercase"><?= $post->categoryName ?></small>
                        <small><?= date("H:i:s d-m-Y", strtotime($post->created_at)) ?> </small>
                        <h1 class="fs-2"><?= $post->name ?></h1>
                        <p class="fs-5"><?= $post->description ?></p>
                        <h2 class="fs-5">Tags:</h2>
                        <div class="row mb-3">
                            <?php
                            foreach ($post_tag as $tag) :
                            ?>
                                <div class="col-4">
                                    <div class="d-grid"><button type="button" class="btn btn-dark btn-sm py-3"><?= $tag->name ?></button></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <?php
                        $getComments = getComments($post->id);
                        if (count($getComments) > 0) :
                            foreach ($getComments as $comment) :
                        ?>
                                <div class="card mt-1">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $comment->first_name . ' ' . $comment->last_name ?></h5>
                                        <p class="fs-6 text-muted"><?= date("H:i:s d-m-Y", strtotime($comment->created_at)) ?></p>
                                        <p class="card-text"><?= $comment->comment ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                Launch static backdrop modal
                                            </button>
                                            <!-- <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">View disslikes</button> -->
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach;
                        else :
                            ?>
                            <p class="text-center fw-bolder fs-3">We dont have any comment at this time!</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>