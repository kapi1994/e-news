<section>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $post = getDataWithFetch('posts', 'id', $id);
            $category = getDataWithFetch('categories', 'id', $post->category_id);
            $tags = getPostTag($post->id);
            $comments = getComments($post->id);
            //var_dump($comments);
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
                                    <div class="d-grid"><a href="#" class="btn btn-dark"><?= $tag->name ?></a></div>
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
                        <?php endif; ?>

                        <?php
                        $comments = getComments($post->id);

                        foreach ($comments as $comment) :
                        ?>
                            <div id="comments">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <em class="float-start fts-italic text-uppercase"><?= $comment->firstName . " " . $comment->lastName ?></em>
                                        <em class="float-end fts-italic text-uppercase text-muted fw-bold"><?= $comment->created_at ?></em>

                                    </div>
                                    <div class="card-body">
                                        <p class="fts-italic"><?= $comment->text ?></p>
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>



                    </div>
                    <div class="col-lg-4">

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

</section>