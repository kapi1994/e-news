<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->roleName == "User" || $_SESSION['user']->roleName == "Journalist") {
        header("Location:admin.php?page=status&code=401");
    }
} else {
    header("Location: index.php?page=status&code=401");
}
?>
<section>
    <div class="container">
        <div class="row my-3">
            <div class="flex-start">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="d-grid">
                            <a href="admin.php?page=category_action" class="btn btn-primary">Add new category</a>
                        </div>

                    </div>
                    <div class="mt-1  mt-md-0 mt-lg-0 col-lg-3">
                        <div class="d-grid"><a href="models/action/exportData.php?action=excel" class="btn btn-danger my-sm- my-md-2 my-lg-0">Export to excel</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-xs-12">
                <div id="categoryResponseMessages"></div>
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Naziv</th>
                                <th scope="col">Datum kreiranja</th>
                                <th scope="col">Datum azuriranja</th>
                                <th scope="col">Izmena</th>
                                <th scope="col">Izbrisi</th>
                            </tr>
                        </thead>
                        <tbody id='categories'>
                            <?php
                            $categoriesCount = categoriesCount();
                            if ($categoriesCount->numberOfCategories  > 0) :
                            ?>
                                <?php
                                $categories = getAll('categories');
                                $rb = 1;
                                foreach ($categories as $category) :
                                ?>
                                    <tr>
                                        <th scope="row"><?= $rb++ ?></th>
                                        <td><?= $category->name ?></td>
                                        <td><?= date("H:i:s d/m/Y", strtotime($category->created_at)) ?></td>
                                        <td><?= $category->updated_at != null ? date("H:i:s d/m/Y", strtotime($category->updated_at)) : "/" ?></td>
                                        <td><a href="admin.php?page=category_action&id=<?= $category->id ?>" class="btn btn-success btn-sm">Update</a></td>
                                        <td><button type="button" class="btn btn-sm btn-danger delete-category" data-id="<?= $category->id ?>">Delete</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <th colspan="6" class="text-center">We don't have any categories at the moment</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>