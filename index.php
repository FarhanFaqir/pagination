<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>Pagination</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<body>

    <style>
        body{
            margin: 0px;
            padding: 0px;
        }
        a {
            margin: 5px;
            padding: 5px;
        }
    </style>

    <div class="container" style="height: 100vh;">
        <div style="padding: auto; margin-left: 300px; padding-top: 100px">
            <?php

            $conn = new mysqli("localhost", "root", "root", "pagination");

            $result = array();
            $index = 0;
            $limit = 5;
            if ($_GET['page']) {
                $page = mysqli_real_escape_string($conn, $_GET["page"]);    
            } else {
                $page = 1;
            }

            $offset = ($page - 1) * $limit;

            $sql = "SELECT * FROM packages LIMIT $limit OFFSET $offset ";
            $res = $conn->query($sql);
            if ($res && $res->num_rows > 0) {
                while ($row = $res->fetch_object()) {
                    $result[$index] = $row;
                    $index++;
                }
            }
        
            // Getting total number of records 
            $sql = "SELECT count(*) FROM packages";
            $res = $conn->query($sql);
            $row = $res->fetch_array();
            $total_rows = $row[0];
            $total_pages = ceil($total_rows / $limit);
            ?>

<div class="card" style="width: 24rem; margin-left: 0px; margin-bottom: 20px">
  <ul class="list-group list-group-flush">
      <li class='list-group-item' style="font-weight: bold;">Package Names</li>
      <?php 
      foreach($result as $r){
        echo "<li class='list-group-item'>" . $r->package_name . "</li>";
      }      
      ?>
  </ul>
</div>

            <ul>
                <!-- <a class="btn btn-primary" href="?page=1">First</a> -->

                <!-- <a class="btn btn-primary" href="<?php if ($page == 1) {echo '#'; } else {$p = $page - 1; echo "?page=" . $p; } ?>">Previous -->

                        <?php

                        if($page > 1){
                            $p = $page -1;
                            echo "<a class='btn btn-primary' href='?page=$p'>Previous</a>"; 
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if($i==$page) $class_name = "btn btn-secondary";
                            else $class_name = "";
                            echo "<a class='{$class_name}' href='?page= $i'>" . $i . "</a>";
                        }

                        if($i-1 > $page){
                            $p = $page + 1;
                            echo "<a class='btn btn-primary' href='?page=$p'>Next</a>"; 
                        }

                        ?>

                        <!-- <a class="btn btn-primary" href="<?php if ($page == $total_pages) {
                                        echo '#';
                                    } else {
                                        $p = $page + 1;
                                        echo "?page=" . $p;
                                    } ?>">Next</a> -->

                        <!-- <a class="btn btn-primary " href="?page= <?php echo $total_pages; ?>">Last</a> -->
            </ul>
        </div>
    </div>

</body>

</html>
