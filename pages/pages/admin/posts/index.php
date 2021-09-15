<?php
if (isset($_SESSION['user'])) {
    var_dump($_SESSION['user']);
    if ($_SESSION['user']->roleName == "Korisnik") {
        header("Location:index.php?page=401");
    }
} else {
    header("Location:index.php?page=status");
}
if ($_SESSION['user']->roleName == "Admin") {
    $posts = getAllPosts();
} else {
    $posts = getOneFetchAndCheckData('posts', 'user_id', $_SESSION['user']->id, 'fetch');
}
?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3">
                <div class="d-grid"><a href="index.php?page=post_action" class="btn btn-primary">Create new post</a></div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-lg-3">
                <div class="mb-3">
                    <input type="text" name="" id="" placeholder="searchPosts" class="form-control">
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
                        <tbody>
                            <?php
                            $rb  = 1;

                            foreach ($posts as $post) :
                            ?>
                                <tr>
                                    <th><?= $rb++ ?></th>
                                    <td><?= $post->name ?></td>
                                    <td><?= $post->categoryName ?></td>
                                    <td><?= $post->headingName ?></td>
                                    <td><?= date("H:i:s d/m/Y", strtotime($post->created_at)) ?></td>
                                    <td><?= $post->updated_at != null ? date("H:i:s d/m/Y", strtotime($post->updated_at)) : "/" ?></td>
                                    <td><a href="index.php?page=post_action&id=<?= $post->id ?>" class="btn btn-sm btn-success">Update</a></td>
                                    <td><button type="button" class="btn btn-sm btn-danger" data-id="">Delete</button></td>
                                    <td><a href="index.php?page=post_details&id=<?= $post->id ?>" class="btn btn-sm btn-info">Details</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>