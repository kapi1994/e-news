<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-3">
                <div class="d-grid"><a href="index.php?page=heading_action" class="btn btn-primary">Heading</a></div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-xs-12">
                <div id="headingResponseMessages"></div>
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Category name</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rb  = 1;
                            $headings = getHeadingWithCategory();
                            foreach ($headings as $heading) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $rb++ ?></th>
                                    <td><?= $heading->name ?></td>
                                    <td><?= $heading->categoryName ?></td>
                                    <td><?= date("H:i:s d/m/Y", strtotime($heading->created_at)) ?></td>
                                    <td><?= $heading->updated_at != null ? date("H:i:s d/m/Y") : "/" ?></td>
                                    <td><a href="index.php?page=heading_action&id=<?= $heading->id ?>" class="btn btn-success btn-sm">Update</a></td>
                                    <td><button class="btn btn-danger btn-sm delete-heading" data-id="<?= $heading->id ?>">Delete</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>