<section>
    <?php
    if (isset($_GET['name'])) {
        $categoryName = $_GET['name'];
        $posts = getPostFromCategory($categoryName);
        $headings = getHeadingsByCategoryName($categoryName);
    } else if (isset($_GET['headingName'])) {
        $headingName = $_GET['headingName'];
        $posts = getHeadingsPosts($headingName);
    } else {
        $tagId = $_GET['tag_id'];
        $tagName = getOneFetchAndCheckData('tags', 'id', $tagId, 'fetch');
        $posts = getSelectedPosts($tagId);
    }

    if (isset($_GET['name'])) :
    ?>
        <div class="container mt-3 d-none d-lg-flex">
            <nav class="nav nav-pills ">

                <?php foreach ($headings as $heading) : ?>
                    <a class="nav-link text-dark fs-5" aria-current="page" href="index.php?page=news&headingName=<?= $heading->headingName ?>"><?= $heading->headingName ?></a>
                <?php endforeach; ?>
            </nav>
            <hr class="d-none d-lg-block">
        </div>
    <?php elseif (isset($_GET['headingName'])) : ?>
        <div class="container mt-3">
            <h1><?= $_GET['headingName'] ?></h1>
        </div>
    <?php else : ?>
        <div class="container mt-3">
            <h1><?= $tagName->name ?></h1>
        </div>
    <?php endif; ?>

    <div class="container">

        <div class="row my-5">
            <?php

            foreach ($posts as $post) :

            ?>
                <div class="col col-md-6 col-lg-3 mb-1">
                    <div class="card box h-100 d-flex flex-column">
                        <img src="assets/images/posts/normal/<?= $post->image_path ?>" class="img-resize" alt="<?= $post->name ?>">

                        <a href="index.php?page=singleNews&id=<?= $post->id ?>" class="nav-link text-dark mt-auto">
                            <h5 class="card-title fs-6"><?= $post->name ?></h5>
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>