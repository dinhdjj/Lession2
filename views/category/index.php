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
</head>
<body>

    <!-- Search -->
    <nav class="navbar navbar-light bg-light">
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
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

</body>
</html>