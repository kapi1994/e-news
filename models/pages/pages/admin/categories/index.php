<?php
if (isset($_SESSION['users']) && $_SESSION['users']->roleName != "Admin") {
    header("Location:index.php?page=status_403");
} else if (!isset($_SESSION['users'])) {
    header("Location:index.php?page=status_403");
}
$categories = getAll("categories");
?>
<section>
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-3">
                <div class="d-grid"><a href="index.php?page=action-categories" class="btn btn-primary">Add new category</a></div>
            </div>
            <div class="col-lg-3 mt-3 mt-lg-0">
                <div class="d-grid">
                    <a href="models/actions/exportData.php?action=excel" class="btn btn-danger">Export to excel</a>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <div id="categoryResponseMessages"></div>
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="categories">
                            <?php
                            if (count($categories) == 0) :
                            ?>
                                <th scope="col" colspan="6">No one category at this time</th>
                            <?php else : ?>
                                <?php
                                $rb = 1;

                                foreach ($categories as $category) :
                                ?>
                                    <tr>
                                        <th scope="row"><?= $rb++ ?></th>
                                        <td><?= $category->name ?></td>
                                        <td><?= $category->created_at ?></td>
                                        <td><?= $category->updated_at ? $category->updated_at : '-' ?></td>
                                        <td><a href="index.php?page=action-categories&id=<?= $category->id ?>" class="btn btn-sm btn-success">Update</a></td>
                                        <td><button type="button" class="btn btn-sm btn-danger delete-category" data-id="<?= $category->id ?>">Delete</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>