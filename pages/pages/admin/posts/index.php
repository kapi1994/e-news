<?php
if (isset($_SESSION['user'])) {
    // var_dump($_SESSION['user']);
    if ($_SESSION['user']->roleName == "User") {
        header("Location:admin.php?page=status&status=401");
    }
} else {
    header("Location:admin.php?page=status&status=401");
}
$user = $_SESSION['user'];
$posts = postPagination($user);
?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3">
                <div class="d-grid"><a href="admin.php?page=post_action" class="btn btn-primary">Create new post</a></div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-lg-3">
                <div class="mb-3">
                    <input type="text" name="searchPosts" id="searchPosts" placeholder="searchPosts" class="form-control">
                </div>
                <div class="mb-3">
                    <p>Serach by category:</p>
                    <?php
                    $categories = getAll("categories");
                    foreach ($categories as $category) :
                    ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?= $category->id ?>" id="category<?= $category->id ?>" name="categories">
                            <label class="form-check-label" for="category<?= $category->id ?>">
                                <?= $category->name ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mb-3">
                    <p>Search by headings:</p>
                    <?php
                    $headings = getAll('headings');
                    foreach ($headings as $heading) :
                    ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?= $heading->id ?>" id="heading<?= $heading->id ?>" name='headings'>
                            <label class="form-check-label" for="heading<?= $heading->id ?>">
                                <?= $heading->name ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mb-3">
                    <p>Filter by creation date:</p>
                    <select name="filterPostByDate" id="filterByDate" class="form-select">
                        <option value="0">Opadujecem</option>
                        <option value="1">Rastucem</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">Name</th>
                                <th scope="row">Category</th>
                                <th scope="row">Heading</th>
                                <th scope="row">Created at</th>
                                <th scope="row">Updated at</th>
                                <th scope="row">Update</th>
                                <th scope="row">Delete</th>
                                <th scope="row">Details</th>
                            </tr>
                        </thead>
                        <tbody id="posts">
                            <?php
                            $postsElements = getNumOfPosts('count');
                            if ($postsElements->numberOfPosts  > 0) :
                            ?>
                                <?php
                                $rb  = 1;

                                foreach ($posts as $post) :
                                ?>
                                    <tr>
                                        <th><?= $rb++ ?></th>
                                        <td><?= cutName($post->name) ?></td>
                                        <td><?= $post->categoryName ?></td>
                                        <td><?= $post->headingName ?></td>
                                        <td><?= date("H:i:s d/m/Y", strtotime($post->created_at)) ?></td>
                                        <td><?= $post->updated_at != null ? date("H:i:s d/m/Y", strtotime($post->updated_at)) : "/" ?></td>
                                        <td><a href="admin.php?page=post_action&id=<?= $post->id ?>" class="btn btn-sm btn-success">Update</a></td>
                                        <td><button type="button" class="btn btn-sm btn-danger" data-id="">Delete</button></td>
                                        <td><a href="admin.php?page=post_details&id=<?= $post->id ?>" class="btn btn-sm btn-info">Details</a></td>
                                    </tr>
                                <?php endforeach;
                            else : ?>
                                <tr>
                                    <th class="text-center" colspan="9">We dont have any post at this moment</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php
                $postsCount = getNumOfPosts('count');
                if ($postsCount->numberOfPosts > 5) :
                ?>
                    <div class="row mt-3">
                        <div class="col-4 mx-auto">
                            <nav aria-label="...">
                                <ul class="pagination" id="postPagination">
                                    <?php
                                    $postPagination = getNumOfPosts('pagination');
                                    for ($i = 0; $i < $postPagination; $i++) :
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