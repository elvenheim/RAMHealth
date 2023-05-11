<div class='pagination-usertable'>
<?php
require_once('admin_connect.php');
    
$rows_per_page = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($page - 1) * $rows_per_page;

$count_query = "SELECT COUNT(*) as count FROM user";
$count_result = mysqli_query($con, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_rows = $count_row['count'];

$total_pages = ceil($total_rows / $rows_per_page);

$sql = "SELECT u.*, r.role_name 
        FROM user u
        JOIN role_type r 
        ON u.user_role = r.role_id
        ORDER BY u.user_id
        LIMIT $offset, $rows_per_page";
$result_table = mysqli_query($con, $sql);

if ($total_pages > 1) {
    $start_page = max(1, $page - 1);
    $end_page = min($total_pages, $start_page + 4);
    if ($end_page - $start_page < 4 && $start_page > 1) {
        $start_page = max(1, $end_page - 4);
    }
    echo "<a href='?page=" . max(1, $page - 1) . "'" . 
        ($page == 1 ? "class='disabled'" : "") . ">Prev</a>";
    for ($i = $start_page; $i <= $end_page; $i++) {
        echo "<a href='?page=$i'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
    }
    echo "<a href='?page=" . min($total_pages, $page + 1) . "'" . 
        ($page == $total_pages ? " class='disabled'" : "") . ">Next</a>";
}
?>
</div>
