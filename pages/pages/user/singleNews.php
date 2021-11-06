<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-10 mx-auto">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $post = getPostWithHeadingAndAuthor($id);
                    $getPostsWithoutThis = getPostsWithoutThis($post->id);
                    $comments = getCommentsWithReaction($post->id);
                    $tags = getSelectedTags($post->id);
                }
                ?>
                <div class="row">
                    <div class="col-lg-8">
                        <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="" class="img-fluid">
                        <div class="d-flex">
                            <p class="text-danger my-3 fs-6"><?= $post->headingName ?></p><span class="my-3 mx-3 text-muted"><?= date("H:i:s d/m/Y", strtotime($post->created_at)); ?></span>
                        </div>
                        <h1 class="mb-3 fs-2"><?= $post->name ?></h1>
                        <p class="fs-5 text-justify"><?= $post->description ?></p>

                        <div class="row">
                            <?php
                            foreach ($tags as $tag) :
                            ?>
                                <div class="col-3">
                                    <div class="d-grid">
                                        <a href="index.php?page=news&tag_id=<?= $tag->id ?>" class="btn btn-primary"><?= $tag->name ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php
                        if (isset($_SESSION['user'])) :
                        ?>
                            <div class="mb-2 clearfix">
                                <form action="#" method="#">
                                    <textarea name="" id="comment" cols="30" rows="5" class="form-control" placeholder="Enter your comment"></textarea>
                                    <div class="col-3 float-end mt-2">
                                        <div class="d-grid"><button class="btn btn-primary" type="button" id="btnComment" data-post="<?= $post->id ?>">Save</button></div>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>

                        <?php

                        foreach ($comments as $comment) :
                        ?>
                            <div class="mt-3" id="comment">
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-hand-thumbs-up <?php if (isset($_SESSION['user']) && $_SESSION['user']->id == $comment->likes->UserId) : ?> text-success <?php else : ?> <?php endif; ?>" viewBox="0 0 16 16">
                                                    <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z" />
                                                </svg>
                                                <big class="ms-3 mt-1"><?= $comment->likes->likes ?></big>
                                            </button>


                                            <button class="btn btn-transparent d-flex vote-action" data-action="disslikes" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>" <?php if (!isset($_SESSION['user'])) : ?> disabled<?php endif; ?>>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-hand-thumbs-up <?php if (isset($_SESSION['user']) && $_SESSION['user']->id == $comment->disslikes->UserId) : ?> text-danger <?php else : ?> <?php endif; ?>>" viewBox="0 0 16 16">
                                                    <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z" />
                                                </svg>
                                                <big class="ms-3 mt-1"><?= $comment->disslikes->disslikes ?></big>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="float-end gap-2">
                                            <?php
                                            $child_comments = countChildComments($comment->id);
                                            if ($child_comments->childComments > 0) :
                                            ?>
                                                <button class="btn btn-primary read-more" type="button" id="btnReadMore<?= $comment->id ?>" data-bs-toggle="collapse" data-bs-target="#comment<?= $comment->id ?>" aria-expanded="false" aria-controls="comment<?= $comment->id ?>" data-comment="<?= $comment->id ?>">
                                                    Show more
                                                </button>
                                            <?php endif; ?>
                                            <?php
                                            if (isset($_SESSION['user'])) :
                                            ?>
                                                <button class=" btn btn-outline-primary" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>" data-bs-toggle="collapse" data-bs-target="#commentReply<?= $comment->id ?>" aria-expanded="false" aria-controls="commentReply<?= $comment->id ?>">Reply</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="collapse my-2" id="comment<?= $comment->id ?>">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="float-start">
                                            <h3 class="fs-6 mt-1">Ime</h3>
                                        </div>
                                        <div class="float-end">
                                            <span class="text-mute">Datum</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-center">Reply text</p>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse" id="commentReply<?= $comment->id ?>">
                                <div class="card card-body">
                                    <textarea name="comment" id="comment_<?= $comment->id ?>" cols="30" rows="5" class="form-control"></textarea>
                                    <div class="row">
                                        <div class="float-end col-3  mt-2">
                                            <div class="d-grid"><button class="btn btn-primary reply-comment" type="button" id="btnCommentReply<?= $comment_id ?>" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>"">Save</button></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <?php endforeach;

                        ?>
                    </div>
                    <div class=" col-lg-4">
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