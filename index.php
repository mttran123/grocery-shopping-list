<!-- 
Name: Mai Tran
Due date: April 10, 2023
Section: CST8285
Lab number: 304
File name: index.php
Description: This PHP file is to build landing page that list a table of shopping items. 
-->


<?php require_once('./dao/itemDAO.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 1000px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }


    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="item">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Grocery Shopping List</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Item</a>
                    </div>
                    <?php
                        $itemDAO = new itemDAO();
                        $items = $itemDAO->getItems();
                        
                        if($items){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Item</th>";
                                        echo "<th>Order Quantity</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Purchase Date</th>";
                                        echo "<th>Image</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach($items as $item){
                                    echo "<tr>";
                                        echo "<td>" . $item->getId(). "</td>";
                                        echo "<td>" . $item->getName() . "</td>";
                                        echo "<td>" . $item->getQuantity() . "</td>";
                                        echo "<td>" . $item->getDescription() . "</td>";
                                        echo "<td>" . $item->getPurchaseDate() . "</td>";
                                        echo "<td><img src=\"images\/" . $item->getImage() . "\" alt=\"" . $item->getImage() . "\"></td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $item->getId() .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $item->getId() .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $item->getId() .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            //$result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                   
                    // Close connection
                    $itemDAO->getMysqli()->close();
                    include 'footer.php';
                    ?>
                </div>
            </div>        
        </div>
    </div>

</body>
</html>