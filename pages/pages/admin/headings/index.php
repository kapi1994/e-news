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
        <div class="row my-3">
            <div class="col-lg-3">
                <div class="d-grid"><a href="admin.php?page=heading_action" class="btn btn-primary">Add new heading</a></div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-lg-3">
                <div>
                    <div class="mb-3">
                        <input type="text" name="searchHeadings" id="searchHeadings" class="form-control" placeholder="Search headings">
                    </div>
                    <div class="mb-3">
                        <label for="">Sort by date:</label>
                        <select name="sortHeading" id="sortHeading" class="form-select">
                            <option value="0">Opadajucem</option>
                            <option value="1">Rastucem</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class=" col-lg-9 col-xs-12">
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
                        <tbody id="headings">
                            <?php
                            $headingsCount = getNumOfHeadings($user, 'count');

                            if ($headingsCount->numOfHeadings > 0) :
                            ?>
                                <?php
                                $rb  = 1;
                                if ($_SESSION['user']->roleName == "Journalist") {
                                    $category_id  = $_SESSION['user']->category_id;;
                                    $headings = getHeadingByCategoryId($category_id);
                                } else {
                                    $headings = getHeadingWithCategory($user);
                                }
                                foreach ($headings as $heading) :
                                ?>
                                    <tr>
                                        <th scope="row"><?= $rb++ ?></th>
                                        <td><?= $heading->name ?></td>
                                        <td><?= $heading->categoryName ?></td>
                                        <td><?= date("H:i:s d/m/Y", strtotime($heading->created_at)) ?></td>
                                        <td><?= $heading->updated_at != null ? date("H:i:s d/m/Y") : "/" ?></td>
                                        <td><a href="admin.php?page=heading_action&id=<?= $heading->id ?>" class="btn btn-success btn-sm">Update</a></td>
                                        <td><button class="btn btn-danger btn-sm delete-heading" data-id="<?= $heading->id ?>">Delete</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <th colspan="7" class="text-center">We dont have any headings at the moment
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php
                    $headingElementsCount =  getNumOfHeadings($user, 'count');

                    if ($headingElementsCount->numOfHeadings > 5) :

                    ?>
                        <div class="row mt-3">
                            <div class="col-4 mx-auto">
                                <nav aria-label="...">
                                    <ul class="pagination" id="headingPagination">
                                        <?php
                                        $headingPagination = getNumOfHeadings($user, 'fetch');

                                        for ($i = 0; $i < $headingPagination; $i++) :
                                            if ($i == 0) :
                                        ?>
                                                <li class="page-item active"><a class="page-link heading-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
                                            <?php
                                            endif;
                                            if ($i != 0) :
                                            ?>
                                                <li class="page-item"><a class="page-link heading-pagination" href="#" data-limit="<?= $i ?>"><?= ($i + 1) ?></a></li>
                                        <?php
                                            endif;
                                        endfor;
                                        ?>

                                    </ul>
                                </nav>
                            </div>
                        </div>

                    <?php

                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>