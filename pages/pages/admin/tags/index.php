<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName == "User") {
        header("Location:index.php?page=status");
    }
} else {
    header("Location:index.php?page=401");
}
?>
<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-3">
                <div class="my-3">
                    <div class="d-grid">
                        <a href="index.php?page=tag_action" class="btn btn-primary">Add new tag</a>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="text" name="searchTags" id="searchTags" placeholder="Search tags" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Order by:</label>
                    <select name="orderTags" id="orderTags" class="form-select">
                        <option value="0">Opadajuce</option>
                        <option value="1">Rastuce</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-lg-9">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="text-center align-middle table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">Name</th>
                                <th scope="row">Created at</th>
                                <th scope="row">Updated at</th>
                                <th scope="row">Update</th>
                                <th scope="row">Delete</th>
                            </tr>
                        </thead>
                        <tbody id='tags'>
                            <?php
                            $rb = 1;
                            $tags = getAll('tags', true, 'created_at');
                            foreach ($tags as $tag) :
                            ?>
                                <tr>
                                    <th><?= $rb++ ?></th>
                                    <td><?= $tag->name ?></td>
                                    <td><?= date("H:i:s d/m/Y", strtotime($tag->created_at)) ?></td>
                                    <td><?= $tag->updated_at != null  ? date("H:i:s d/m/Y", strtotime($tag->updated_at)) : '/' ?></td>
                                    <td><a href="index.php?page=tag_action&id=<?= $tag->id ?>" class="btn btn-success btn-sm">Update</a></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" data-id="<?= $tag->id ?>">Delete</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>