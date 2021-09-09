<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-3">
                <div class="mb-3">
                    <input type="text" name="" id="" placeholder="Search tags" class="form-control">
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
                        <tbody>
                            <?php
                            $rb = 1;
                            $tags = $conn->query("SELECT * FROM tags")->fetchAll();
                            foreach ($tags as $tag) :
                            ?>
                                <tr>
                                    <th><?= $rb++ ?></th>
                                    <td><?= $tag->name ?></td>
                                    <td><?= date("H:i:s d/m/Y", strtotime($tag->created_at)) ?></td>
                                    <td><?= $tag->updated_at != null  ? date("H:i:s d/m/Y", strtotime($tag->updated_at)) : '/' ?></td>
                                    <td><a href="#" class="btn btn-success btn-sm">Update</a></td>
                                    <td><button type="button" class="btn btn-danger btn-sm">Delete</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>