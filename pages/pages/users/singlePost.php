<section>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $post = getDataWithFetch('posts', 'id', $id);
            $category = getDataWithFetch('categories', 'id', $post->category_id);
            $tags = getPostTag($post->id);
            $comments = getComments($post->id);
            var_dump($comments);
            $getWithoutThis = $conn->query("SELECT * FROM posts WHERE id!=$id  ORDER BY created_at LIMIT 3")->fetchAll();
        }

        ?>
        <div class="row my-3">
            <div class="col-lg-10 mx-auto">
                <div class="row">
                    <div class="col-lg-8">
                        <picture>
                            <img src="assets/images/posts/normal/<?= $post->image_path ?>" alt="<?= $post->name ?>" class="img-fluid">
                        </picture>
                        <p class="text-uppercase text-danger fw-bold my-2"><?= $category->name ?><span class="ms-3 text-muted"><?= date('H:i:s  d-m-Y', strtotime($post->created_at)) ?></span></p>
                        <h1 class="mb-2 fs-2"><?= $post->name ?></h1>
                        <p class="fs-5"><?= $post->description ?></p>
                        <div class="row mb-3">
                            <?php
                            foreach ($tags as $tag) :
                            ?>
                                <div class="col-3">
                                    <div class="d-grid"><a href="index.php?page=news&tag_id=<?= $tag->id ?>" class="btn btn-dark"><?= $tag->name ?></a></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php
                        if (isset($_SESSION['users'])) :
                        ?>
                            <div class="my-3">
                                <textarea class="textarea-commnet form-control" cols="30" rows="3" placeholder="Enter your comment..."></textarea>
                                <div class="text-end">
                                    <button class="btn btn-outline-primary  mt-2  submitComment" name="btnSubmit" id='btnSubmit' type="button" data-id="0" data-post="<?= $post->id ?>">Submit</button>
                                </div>
                            </div>
                        <?php else : ?>
                        <?php endif; ?>
                        <?php

                        foreach ($comments as $comment) :
                            if (isset($_SESSION['users'])) {
                                $id = isset($_SESSION['users']) ? $_SESSION['users']->id : '';
                                $userLikes = $conn->query("SELECT user_id FROM reactions WHERE comment_id = $comment->id AND user_id = $id  AND likes != 0")->fetch();
                                $userDislike = $conn->query("SELECT user_id FROM reactions WHERE comment_id = $comment->id AND user_id = $id AND disslikes > 0")->fetch();
                            }
                            $countLikes = $conn->query("SELECT COUNT(likes) as likes FROM reactions WHERE comment_id = $comment->id AND likes > 0 LIMIT 1")->fetch();
                            $countDislike = $conn->query("SELECT COUNT(disslikes) as disslike FROM reactions WHERE comment_id = $comment->id AND disslikes > 0 LIMIT 1")->fetch();
                        ?>
                            <div id="comments">

                                <div class="card mb-2">
                                    <div class="card-header">
                                        <div class="float-start fw-bold"><?= $comment->firstName ?></div>
                                        <div class="float-end fst-italic"><small class="text-muted"><?= date('d-m-Y H:i:s', strtotime($comment->created_at)) ?></small></div>
                                    </div>
                                    <div class="card-body">
                                        <p class="font-italic"><?= $comment->text ?></p>
                                        <div class="float-start">
                                            <button class="btn btn-transparent btn-like" <?php if (!isset($_SESSION['users'])) : ?> disabled<?php endif; ?>data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-hand-thumbs-up-fill <?php if ($userLikes && $userLikes->user_id == $id) : ?>text-success<?php else : ?>text-dark<?php endif; ?>" viewBox="0 0 16 16">
                                                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                                                </svg></button><span class=" mt-4 me-2 likeComment" id="likeComment<?= $comment->id ?>"><?= $countLikes->likes > 0 ? $countLikes->likes : 0 ?></span>
                                            <button class="btn btn-transparent btn-disslike" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>"><svg xmlns=" http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-hand-thumbs-down-fill <?php if ($userDislike && $userDislike->user_id == $id) : ?> text-danger <?php else : ?> text-dark<?php endif; ?>" viewBox="0 0 16 16">
                                                    <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />
                                                </svg>
                                            </button><span class=" mt-3 disslikeComment" id="disslikeComment<?= $comment->id ?>"><?= $countDislike->disslike > 0 ? $countDislike->disslike : 0 ?></span>
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                        <div class="float-end">
                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#comment<?= $comment->id ?>" aria-expanded="false" aria-controls="comment<?= $comment->id ?>">
                                                Read more
                                            </button>

                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#comment_reply<?= $comment->id ?>" aria-expanded="false" aria-controls="comment_reply<?= $comment->id ?>" data-id="<?= $comment->id ?>" data-id-post="<?= $post->id ?>">
                                                Reply
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="collapse  my-2" id="comment_reply<?= $comment->id ?>">
                                    <div class="row">
                                        <div class="col-10 ms-auto">
                                            <div class="card">
                                                <div class="card-header">
                                                    Reply to: <span class="fts-italic fw-bold">@<?= $comment->firstName ?></span>
                                                </div>
                                                <div class="card-body">
                                                    <textarea name="" cols="30" rows="5" class="form-control" id="reply_comment<?= $comment->id ?>"></textarea>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="float-end">
                                                        <button class="btn btn-outline-secondary cancel-comments" data-id=<?= $comment->id ?> data-post="<?= $post->id ?>" type="button">Cancel</button>
                                                        <button class="btn btn-outline-primary comment-reply" type="button" data-comment="<?= $comment->id ?>" data-post=" <?= $post->id ?>">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="collapse  my-2" id="comment<?= $comment->id ?>">
                                    <div class="row d-flex justify-content-end">
                                        <div class="col-10">
                                            <div class="">
                                                <div class="card my-2">
                                                    <div class="card-header">
                                                        Repiled by : <span class="fw-bold fts-italic">@Nemanja</span>
                                                        <span class="float-end text-muted">
                                                            21:11:11
                                                        </span>
                                                    </div>
                                                    <div class="card-body">
                                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic natus consectetur sunt eaque impedit velit voluptates itaque minus quam ab?</p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="float-end">
                                                            <button class="btn btn-outline-secondary cancel-comments" data-id=<?= $comment->id ?> data-post="<?= $post->id ?>" type="button">Cancel</button>
                                                            <button class="btn btn-outline-primary comment-reply" type="button" data-comment="<?= $comment->id ?>" data-post=" <?= $post->id ?>">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-lg-4 mt-5 mt-md-0 mt-lg-0">
                        <?php foreach ($getWithoutThis as $gt) : ?>
                            <div class="row">
                                <div class="col">
                                    <div class="row my-2">
                                        <div class="col-4">
                                            <picture><img src="assets/images/posts/thumbnail/<?= $gt->image_path ?>" alt="<?= $gt->name ?>" class="img-fluid"></picture>
                                        </div>
                                        <div class="col-8">
                                            <a href="index.php?page=single-post&id=<?= $gt->id ?>" class="nav-link text-dark">
                                                <h3 class="fs-5"><?= $gt->name ?></h3>
                                            </a>
                                            <p class="text-muted"><?= date("H:i:s d-m-Y", strtotime($gt->created_at)); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>



                </div>

            </div>

        </div>
    </div>
    </div>
</section>