<?php
    require_once('air_technician_connect.php');

    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM aq_particulate_matter";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);
    
    echo "<div class='pagination'>";
    if ($total_pages > 1) {
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $start_page + 4);
        if ($end_page - $start_page < 4 && $start_page > 1) {
            $start_page = max(1, $end_page - 4);
        }
    
        $sortParam = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] : "";
    
        if ($page == 1) {
            echo "<span class='pagination-disabled'>Prev</span>";
        } else {
            echo "<a href='?page=" . ($page - 1) . "$sortParam'>Prev</a>";
        }
    
        for ($i = $start_page; $i <= $end_page; $i++) {
            echo "<a href='?page=$i$sortParam'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
        }
    
        if ($page == $total_pages) {
            echo "<span class='pagination-disabled'>Next</span>";
        } else {
            echo "<a href='?page=" . ($page + 1) . "$sortParam'>Next</a>";
        }
    }
    echo "</div>"; 
?>