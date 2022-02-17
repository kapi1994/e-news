<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName == "User") {
        header("Location:admin.php?page=status&code=401");
    }
} else {
    header("Location:admin.php?page=status&code=401");
}
$user = $_SESSION['user'];
?>
<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-3">
                <div class="mb-3">
                    <div class="d-grid">
                        <a href="admin.php?page=tag_action" class="btn btn-primary">Add new tag</a>
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
                <div id="printTagCrudMessage"></div>
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
                            $tagElemenets = getNumOfTags($user, 'count');
                            if ($tagElemenets->numOfTags > 0) :
                            ?>
                                <?php
                                $rb = 1;
                                $user = $_SESSION['user'];
                                $tags = getAllTags($user);
                                foreach ($tags as $tag) :
                                ?>
                                    <tr>
                                        <th><?= $rb++ ?></th>
                                        <td><?= $tag->name ?></td>
                                        <td><?= date("H:i:s d/m/Y", strtotime($tag->created_at)) ?></td>
                                        <td><?= $tag->updated_at != null  ? date("H:i:s d/m/Y", strtotime($tag->updated_at)) : '/' ?></td>
                                        <td><a href="admin.php?page=tag_action&id=<?= $tag->id ?>" class="btn btn-success btn-sm">Update</a></td>
                                        <td><button type="button" class="btn btn-danger btn-sm delete-tag" data-id="<?= $tag->id ?>">Delete</button></td>
                                    </tr>
                                <?php endforeach;
                            else :
                                ?>
                                <tr>
                                    <th colspan="6" class="text-center">At this moment we dont have any tags</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php
                    $tagElemenets = getNumOfTags($user, 'count');
                    if ($tagElemenets->numOfTags > 5) :
                    ?>
                        <div class="row mt-3">
                            <div class="col col-lg-8 mx-auto">
                                <nav aria-label="...">
                                    <ul class="pagination" id="tagPagination">
                                        <?php
                                        $tagPagination = getNumOfTags($user, 'pagination');
                                        for ($i = 0; $i < $tagPagination; $i++) :
                                            if ($i == 0) :
                                        ?>
                                                <li class="page-item active"><a class="page-link tag-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
                                            <?php
                                            endif;
                                            if ($i != 0) :
                                            ?>
                                                <li class="page-item"><a class="page-link tag-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
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
    </div>
</section>