<?php
// Include itemDAO file
require_once('./dao/itemDAO.php');
 
// Define variables and initialize with empty values
$name = $quantity = $description = $date = $image_name = "";
$name_err = $quantity_err = $description_err = $date_err = $image_err = "";
$itemDAO = new itemDAO(); 

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate item name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid item name.";
    } else if(strlen($input_name) >100) {
        $name_err = "Item name cannot be more than 100 character long.";
    } else{
        $name = $input_name;
    }

     // Validate quantity
     $input_quantity = trim($_POST["quantity"]);
     if(empty($input_quantity)){
         $quantity_err = "Please enter the quantity amount.";     
     } elseif(!ctype_digit($input_quantity) || ($input_quantity>20) ){
         $quantity_err = "Please enter a positive integer value. Quantity should not exceed 20.";
     } else{
         $quantity = $input_quantity;
     }

    // Validate description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter a description.";     
    } elseif (strlen($input_description) <250) {
        $description = $input_description;
    } else {
        $description_err = "Text will not allow more than 250 characters.";
    }

    // Validate date
    $input_date = trim($_POST["date"]);
    // $datetime = DateTime::createFromFormat('YYYY-mm-dd', $input_date);
    if(empty($input_date)){
        $date_err = "Please enter the purchase date.";     
    } elseif( preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $input_date)){
        $limit_date = new DateTime('2023-01-01'); 
        if(new DateTime($input_date) < $limit_date) {
            $date_err = "Please enter a date on or after 2023-01-01.";
        } else {
            $date = $input_date;    
        }  
    } else{
        $date_err = "Please enter a correct date format YYYY-MM-DD.";
    }

    if(isset($_POST["submit"])) {
        $targetDir = "./images/";
        $image_name = $_FILES["image"]["name"];

        if(empty($image_name)){
            $image_err = "Please upload an image file";
        } else {    
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
      
       
        // Check file size
        if ($_FILES["image"]["size"] > 100000) {
            $image_err = "File size should not exceed 100Kb";
            $uploadOk = 0;
        }
      
        $extensions= array("jpeg","jpg","png", "gif");
        // Allow only image file formats
        if(in_array($imageFileType, $extensions) == false) {
            $image_err = "Please choose a JPG, JPEG or PNG file";
            $uploadOk = 0;
        }
      
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {                
                echo "";
            } else {
                $image_err = "There is an error uploading your file.:(";
            }
        }        
        }
    }
       
    // Check input errors before inserting in database
    if(empty($name_err) && empty($description_err) && empty($quantity_err) && empty($date_err) && empty($image_err)){
        $item = new Item($id, $name, $quantity, $description, $date, $image_name);
        $result = $itemDAO->updateItem($item);        
		header("refresh:2; url=index.php");
		echo '<br><h6 style="text-align:center">' . $result . '</h6>';
        // Close connection
        $itemDAO->getMysqli()->close();
    }

} else {
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $item = $itemDAO->getItem($id);
                
        if($item){
            // Retrieve individual field value    
            $name = $item->getName();
            $quantity = $item->getQuantity();
			$description = $item->getDescription();
			$date = $item->getPurchaseDate();
            $image = $item->getImage();
        } else{
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $itemDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 1000px;
            margin: 0 auto;
        }
        label {
            display: block;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the item information and submit to update the item record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label>Item</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Order Quantity</label>
                            <input type="text" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>" placeholder="max 20">
                            <span class="invalid-feedback"><?php echo $quantity_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Item Description</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" placeholder="max 250 characters"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Purchase Date</label>
                            <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>" placeholder="YYYY-MM-DD">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="<?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image_name; ?>">
                            <span class="invalid-feedback"><?php echo $image_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Update" name="submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>