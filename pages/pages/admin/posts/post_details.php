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
        $comments = getCommentsWithReaction($post->id);
        $postTags = getSelectedTags($_GET['id']);
        $user_id = $_SESSION['user']->id;
    }
    ?>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-7">
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
                        <div class="col-3 mt-1">
                            <div class="d-grid"><button class="btn btn-outline-dark btn-sm"><?= $postTag->name ?></button></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-5">
                <?php

                foreach ($comments as $comment) :

                ?>
                    <div class="card my-1">
                        <div class="card-header">
                            <div class="ms-2 float-start fw-bold">
                                <?= $comment->firstName . ' ' . $comment->lastName ?>
                            </div>
                            <div class="float-end me-2 text-muted fst-italic fw-bold">
                                <?= date("H:i:s d/m/Y", strtotime($comment->created_at)) ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= $comment->text ?>
                            <div class="d-flex gap-3 mt-2">
                                <button class="btn btn-transparent text-center reaction-like" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-hand-thumbs-up-fill text-success" viewBox="0 0 16 16">
                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                                    </svg> <span class="d-inline-block align-middle ms-2" id=" countLike<?= $comment->id ?>"><?= $comment->likes->likesCount ?></span>
                                </button>
                                <button class="btn btn-transparent text-center reaction-disslike" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-hand-thumbs-down-fill text-danger" viewBox="0 0 16 16">
                                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />
                                    </svg> <span class="d-inline-block align-middle ms-2" id=" countLike<?= $comment->id ?>"><?= $comment->disslikes->disslikesCount ?></span>
                                </button>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="float-end gap-2">
                                <button class="btn btn-primary read-more" data-user="<?= $user_id ?>" type="button" data-bs-toggle="collapse" data-bs-target="#comment<?= $comment->id ?>" aria-expanded="false" aria-controls="comment<?= $comment->id ?>" data-comment="<?= $comment->id ?>" id="buttonCollapse<?= $comment->id ?>">
                                    Show <span class="ms-3"><?= $comment->countChild->childComments ?></span>
                                </button>
                                <button class=" btn btn-outline-primary comment-reply" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>" data-bs-toggle="collapse" data-bs-target="#commentReply<?= $comment->id ?>" aria-expanded="false" aria-controls="commentReply<?= $comment->id ?>">Reply</button>

                                <button type="button" class="btn btn-outline-dark btn-reactions" data-bs-toggle="modal" data-bs-target="#reaction<?= $comment->id ?>" data-comment="<?= $comment->id ?>">
                                    Show user reactions
                                </button>
                                <!-- Modal -->
                                <div class=" modal fade" id="reaction<?= $comment->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Reakcije na komentar: </h5>
                                                <span class="ms-5"><?= date("H:i:s d/m/Y", strtotime($comment->created_at)) ?></span>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id='reactions<?= $comment->id ?>'>
                                                ...
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse my-2" id="comment<?= $comment->id ?>">

                    </div>

                    <div class="collapse" id="commentReply<?= $comment->id ?>">

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<div class="collapse my-2" id="comment<?= $comment->id ?>">

</div>

<div class="collapse" id="commentReply<?= $comment->id ?>">

</div>