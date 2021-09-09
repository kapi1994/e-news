<section>
    <div class="container">
        <div class="row my-3">
            <div class="flex-start">
                <div class="col-lg-3">
                    <div class="d-grid">
                        <a href="index.php?page=category_action" class="btn btn-primary">Add new category</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-xs-12">
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
                        <tbody>
                            <?php
                            $categories = getAll('categories');
                            $rb = 1;
                            foreach ($categories as $category) :

                                // foreach ($categories as $category) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $rb++ ?></th>
                                    <td><?= $category->name ?></td>
                                    <td><?= date("H:i:s d/m/Y", strtotime($category->created_at)) ?></td>
                                    <td><?= $category->updated_at != null ? date("H:i:s d/m/Y", strtotime($category->updated_at)) : "/" ?></td>
                                    <td><a href="index.php?page=category_action&id=<?= $category->id ?>" class="btn btn-success btn-sm">Update</a></td>
                                    <td><button type="button" class="btn btn-sm btn-danger " data-id="<?= $category->id ?>">Delete</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>