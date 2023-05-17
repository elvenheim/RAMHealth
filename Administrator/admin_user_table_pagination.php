<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script> 
    $('#user-list-pagination').on('click', 'a', function(e) {
    e.preventDefault();
    var page = $(this).data('page');
    $('#table-body').load('admin_table.php?page=' + page);
    });
</script>

<ul id="user-list-pagination" class="pagination">
    <?php
        require_once('admin_connect.php');
        
        $rows_per_page = 10;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $offset = ($page - 1) * $rows_per_page;

        $count_query = "SELECT COUNT(*) as count FROM user_list";
        $count_result = mysqli_query($con, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $total_rows = $count_row['count'];

        $total_pages = ceil($total_rows / $rows_per_page);

        if ($total_pages > 1) {
            $start_page = max(1, $page - 2);
            $end_page = min($total_pages, $start_page + 4);

            if ($end_page - $start_page < 5 && $start_page > 1) {
                $start_page = max(1, $end_page - 5);
            }

            echo "<a href='?page=" . max(1, $page - 1) . "'" . 
                ($page == 1 ? "class='disabled'" : "") . ">Prev</a>";

            for ($i = $start_page; $i <= $end_page; $i++) {
                if ($i <= $total_pages && $i > 0) {
                    echo "<a href='?page=$i'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
                }
            }

            echo "<a href='?page=" . min($total_pages, $page + 1) . "'" . 
                ($page == $total_pages ? " class='disabled'" : "") . ">Next</a>";
        }
    ?>
</ul>
