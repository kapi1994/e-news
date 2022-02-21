<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-10 mx-auto">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $user_id = isset($_SESSION['user']) ? $_SESSION['user']->id : '';
                    $post = getPostWithHeadingAndAuthor($id);
                    $getPostsWithoutThis = getPostsWithoutThis($post->id);
                    $comments = getCommentsWithReaction($post->id, $user_id);
                    $tags = getSelectedTags($post->id);
                }
                ?>
                <div class="row">
                    <div class="col-lg-8">

                        <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="" class="img-fluid">
                        <div class="d-flex">
                            <p class="text-danger my-3 fs-6"><?= $post->headingName ?></p><span class="my-3 mx-3 text-muted fw-bold">Autor: <?= $post->first_name . " " . $post->last_name ?></span><span class="my-3 mx-3 text-muted"><?= date("H:i:s d/m/Y", strtotime($post->created_at)); ?></span>

                        </div>
                        <h1 class="mb-3 fs-2"><?= $post->name ?></h1>
                        <p class="fs-5 text-justify"><?= $post->description ?></p>

                        <div class="row mb-2">
                            <?php
                            foreach ($tags as $tag) :
                            ?>
                                <div class="col-3">
                                    <div class="d-grid">
                                        <a href="index.php?page=news&tag_id=<?= $tag->id ?>" class="btn btn-sm btn-outline-dark mb-1"><?= $tag->name ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php
                        if (isset($_SESSION['user'])) :
                        ?>
                            <div class="mb-2 clearfix">
                                <form action="#" method="#">
                                    <textarea name="comment" id="comment" cols="30" rows="5" class="form-control" placeholder="Enter your comment"></textarea>
                                    <div class="col-3 float-end mt-2">
                                        <div class="d-grid"><button class="btn btn-primary" type="button" id="btnComment" data-post="<?= $post->id ?>">Save</button></div>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                        <div id="comments_display">
                            <?php

                            foreach ($comments as $comment) :

                            ?>
                                <div class="mt-3">
                                    <div class="card mb-1">
                                        <div class="card-header">
                                            <div class="float-start">
                                                <h2 class="fs-6 mt-1"><?= $comment->firstName . " " . $comment->lastName ?></h2>
                                            </div>
                                            <div class="float-end">
                                                <span class="text-muted"><?= date("H:i:s d/m/Y", strtotime($comment->created_at)); ?></span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><?= $comment->text ?></p>
                                            <div class="gap-3 d-flex">
                                                <button class="btn btn-transparent d-flex vote-action" id="like-<?= $comment->id ?>" data-action="likes" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>" <?php if (!isset($_SESSION['user'])) : ?> disabled <?php endif; ?>>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" id="voteLike<?= $comment->id ?>" class="bi bi-hand-thumbs-up <?php if (isset($_SESSION['user']) && $comment->user_reaction != FALSE && $user_id == $comment->user_reaction->user_id && $comment->user_reaction->likes > 0) : ?>text-success <?php else : ?> text-dark <?php endif; ?>" viewBox=" 0 0 16 16">
                                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                                                    </svg>
                                                    <span class="d-inline-block align-middle ms-2" id="countLike<?= $comment->id ?>"><?= $comment->likes->likesCount ?></span>
                                                </button>


                                                <button class="btn btn-transparent d-flex vote-action" id="disslike-<?= $comment->id ?>" data-action="disslikes" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>" <?php if (!isset($_SESSION['user'])) : ?> disabled<?php endif; ?>>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" id="voteDisslike<?= $comment->id ?>" class="bi bi-hand-thumbs-up <?php if (isset($_SESSION['user']) && $comment->user_reaction != FALSE && $user_id == $comment->user_reaction->user_id && $comment->user_reaction->disslikes > 0) : ?>text-danger <?php else : ?> text-dark <?php endif; ?>" viewBox="0 0 16 16">
                                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                                                    </svg>
                                                    <span class="d-inline-block align-middle ms-2" id="countDisslike<?= $comment->id ?>"><?= $comment->disslikes->disslikesCount ?></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="float-end gap-2">
                                                <?php
                                                if ($comment->countChild->childComments > 0) :
                                                ?>
                                                    <button class="btn btn-primary read-more" data-user="<?= $user_id ?>" type="button" data-bs-toggle="collapse" data-bs-target="#comment<?= $comment->id ?>" aria-expanded="false" aria-controls="comment<?= $comment->id ?>" data-comment="<?= $comment->id ?>" id="buttonCollapse<?= $comment->id ?>">
                                                        Show
                                                    </button>
                                                <?php endif; ?>
                                                <?php
                                                if (isset($_SESSION['user'])) :
                                                    $user_id = isset($_SESSION['user']) ? $_SESSION['user']->id : "";
                                                ?>
                                                    <button class=" btn btn-outline-primary comment-reply" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>" data-bs-toggle="collapse" data-bs-target="#commentReply<?= $comment->id ?>" aria-expanded="false" aria-controls="commentReply<?= $comment->id ?>">Reply</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row d-flex flex-column">
                            <?php
                            foreach ($getPostsWithoutThis as $pGet) :
                            ?>
                                <div class="row">
                                    <div class=" card mb-1">

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <img src="assets/images/posts/thumbnail/<?= $pGet->image_path ?>" alt="<?= $pGet->name ?>" class="img-fluid mt-4">
                                                </div>
                                                <div class="col-6">
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
                                </div>


                                <div class="collapse my-2" id="comment<?= $comment->id ?>">

                                </div>

                                <div class="collapse" id="commentReply<?= $comment->id ?>">

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
    </div>
</section>