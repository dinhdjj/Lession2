<?php

$renderCategoryRow = function ($category, $level = 0) use (&$renderCategoryRow) {
    $html = '';
    $html .= '<tr>';
    $html .= '<th scope="row">'.htmlspecialchars($category->id).'</th>';
    $html .= '<td>'.str_repeat('----', $level).htmlspecialchars($category->name).'</td>';
    $html .= '<td>';
    $html .= '<a href="/update?id='.$category->id.'">Update</a>';
    $html .= '<a href="/delete?id='.$category->id.'">Delete</a>';
    $html .= '</td>';
    $html .= '</tr>';

    foreach ($category->children as $child) {
        $html .= $renderCategoryRow($child, $level + 1);
    }

    return $html;
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LE VAN DINH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>

    <!-- Search -->
    <nav class="navbar navbar-light bg-light">
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-category-modal">
            Create
        </button>
    </nav>

    <!-- List categories -->
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>   
            <?php foreach ($categories as $category) {
                echo $renderCategoryRow($category);
            } ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if ($currentPage > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $currentPage - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <?php } ?>

            <?php foreach (range(1, $totalPage) as $page) { ?>
                <li class="page-item <?php echo $page == $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?php echo $page ?>"><?php echo $page ?></a>
                </li>
            <?php } ?>
            
            <?php if ($totalPage > $currentPage) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>    

    <!-- Create category -->
    <div class="modal" id="create-category-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/store">
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Create Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-category-name">Category Name</label>
                            <input type="text" class="form-control" id="create-category-name" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="create-category-parent-id">Parent Category</label>
                            <br>
                            <select id="create-category-parent-id" class="form-control" name="parent_id" placeholder="Parent name">
                                <?php foreach ($allCategories as $category) { ?>
                                    <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script >
        $(document).ready(function () {
            $('#create-category-parent-id').select2();
        });
    </script>
</body>
</html>