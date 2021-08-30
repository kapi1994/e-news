<?php
$headings = getHeadingsWithCategories();
if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}
?>
<section>
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-3">
                <div class="d-grid"><a href="index.php?page=action-heading" class="btn btn-primary">Add new heading</a></div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <div id="showResponseErrorMessages"></div>
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category name</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id='headings'>
                            <?php
                            $rb = 1;
                            $headings = $conn->query("SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id")->fetchAll();
                            if (count($headings) > 0) :
                                foreach ($headings as $heading) :
                            ?>
                                    <tr>
                                        <th><?= $rb++ ?></th>
                                        <td><?= $heading->name ?></td>
                                        <td><?= $heading->categoryName ?></td>
                                        <td><?= $heading->created_at ?></td>
                                        <td><?= $heading->updated_at ? $heading->updated_at : '-' ?></td>
                                        <td><a href="index.php?page=action-heading&id=<?= $heading->id ?>" class=" btn btn-sm btn-success">Update</a></td>
                                        <td><button type="button" class="btn btn-danger btn-sm delete-heading" data-id="<?= $heading->id ?>">Delete</button></td>
                                    </tr>
                                <?php endforeach;
                            else :
                                ?>
                                <tr>
                                    <th scope="row" colspan="7">No headings at this moment</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>