<?php
if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}
?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3">
                <div class="d-grid">
                    <a href="index.php?page=action-tag" class="btn btn-primary">Create new tag</a>
                </div>
                <div class="mt-2">
                    <input type="text" name="searchTags" id="searchTags" class="form-control" placeholder="Search tags...">
                </div>
                <div class="my-2">
                    <select name="sortByDateTags" id="sortByDateTag" class="form-select">
                        <option value="0">Sort by:</option>
                        <option value="1">Opadajucem</option>
                        <option value="2">Rastucem</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="table-responsive-sm table-responsive-md">
                        <table class="table text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created at</th>
                                    <th>Update at</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="tags">
                                <?php
                                $rb  = 1;
                                $tags = tagPagination();
                                if (count($tags) > 0) :
                                    foreach ($tags as $tag) :
                                ?>
                                        <tr>
                                            <th><?= $rb++ ?></th>
                                            <td><?= $tag->name ?></td>
                                            <td><?= $tag->created_at ?></td>
                                            <td><?= $tag->updated_at ? $tag->updated_at : '-' ?></td>
                                            <td><a href="index.php?page=action-tag&id=<?= $tag->id ?>" class="btn btn-success btn-sm">Update</a></td>
                                            <td><button type="button" class="btn btn-danger btn-sm delete-tag" data-id="<?= $tag->id ?>">Delete</button></td>
                                        </tr>
                                    <?php endforeach;
                                else : ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                if (count($tags) >= 5) :
                ?>
                    <div class="row mt-3">
                        <div class="col-4 mx-auto">
                            <nav aria-label="...">
                                <ul class="pagination" id="tagPagination">
                                    <?php
                                    $tagPages = getNumOfPagesTags();
                                    for ($i = 0; $i < $tagPages; $i++) :
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
</section>