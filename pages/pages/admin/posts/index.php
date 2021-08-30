<?php


if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}
$posts = postPagination();
?>
<section>
    <div class="container">

        <div class="row my-3">

            <div class="col-lg-3">
                <div class="d-grid">
                    <a href="index.php?page=action-post" class="btn btn-primary">Create new post</a>
                </div>
                <!--  -->
                <div class="my-2">
                    <input type="text" name="searchPost" id="searchPost" class="form-control" placeholder="Search posts....">
                </div>
                <div class="mb-3">
                    <h3 class="fs-5">Categories:</h3>
                    <div class="mb-1">
                        <?php
                        $categories  = getAll('categories');
                        foreach ($categories as $category) :
                        ?>
                            <div class="form-check">
                                <input class="form-check-input categories" type="checkbox" value="<?= $category->id ?>" id="gerne_<?= $category->id ?>" name="product_categories">
                                <label class="form-check-label" for="<?= $category->id ?>">
                                    <?= $category->name ?>
                                </label>
                            </div><?php endforeach; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <h3 class="fs-5">Headings:</h3>
                    <?php
                    $headings = getAll('headings');
                    foreach ($headings as $heading) :
                    ?>
                        <div class="form-check">
                            <input class="form-check-input headings" type="checkbox" value="<?= $heading->id ?>" id="gerne_<?= $heading->id ?>" name="product_heading">
                            <label class="form-check-label" for="<?= $heading->id ?>">
                                <?= $heading->name ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mb-3">
                    <h3 class="fs-5">Sort by date:</h3>
                    <select name="sortByDatePost" id="sortByDatePost" class="form-select">
                        <option value="0">Choose:</option>
                        <option value="1">Opadajucem</option>
                        <option value="2">Rastucem</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-9">
                <div id="postShowErrorMessages"></div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive-sm table-responsive-md">
                            <table class="table text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category name</th>
                                        <th>Heading name</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="posts">
                                    <?php
                                    $rb = 1;
                                    if (count($posts) > 0) :
                                        foreach ($posts as $post) :
                                    ?>
                                            <tr>
                                                <th><?= $rb++ ?></th>
                                                <td><?= $post->name ?></td>
                                                <td><?= $post->categoryName ?></td>
                                                <td><?= $post->headingName ?></td>
                                                <td><?= date("H:i:s d/m/Y", strtotime($post->created_at)) ?></td>
                                                <td><?= $post->updated_at ? date("H:i:s d/m/Y", strtotime($post->updated_at)) : '/' ?></td>
                                                <td><a href="index.php?page=action-post&id=<?= $post->id ?>" class="btn btn-sm btn-success">Update</a></td>
                                                <td><button type="button" class="btn btn-sm btn-danger delete-post" data-id="<?= $post->id ?>">Delete</button></td>
                                                <td><a href="index.php?page=post_details&id=<?= $post->id ?>" class="btn btn-sm btn-info">Details</a></td>
                                            </tr>
                                        <?php endforeach;
                                    else : ?>
                                        <tr>
                                            <th scope="row" colspan="8">No post at the moment</th>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <?php if (count($posts) >= 5) : ?>
                    <div class="row">
                        <div class="col-4 mx-auto">
                            <nav aria-label="...">
                                <ul class="pagination" id="postPagination">
                                    <?php
                                    $postPages = numberOfPostPages();
                                    for ($i = 0; $i < $postPages; $i++) :
                                        if ($i == 0) :
                                    ?>
                                            <li class="page-item active"><a class="page-link post-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
                                        <?php
                                        endif;
                                        if ($i != 0) :
                                        ?>
                                            <li class="page-item"><a class="page-link post-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
                                    <?php
                                        endif;
                                    endfor;
                                    ?>

                                </ul>
                            </nav>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>