<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-xs-12">
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
                            $headings = $conn->query("SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id")->fetchAll();
                            foreach ($headings as $heading) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $rb++ ?></th>
                                    <td><?= $heading->name ?></td>
                                    <td><?= $heading->categoryName ?></td>
                                    <td><?= date("H:i:s d/m/Y", strtotime($heading->created_at)) ?></td>
                                    <td><?= $heading->updated_at != null ? date("H:i:s d/m/Y") : "/" ?></td>
                                    <td><a href="" class="btn btn-success btn-sm">Update</a></td>
                                    <td><button class="btn btn-danger btn-sm">Delete</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>