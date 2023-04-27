<!-- 
Name: Mai Tran
Due date: April 10, 2023
Section: CST8285
Lab number: 304
File name: create.php
-->

<?php
require_once('abstractDAO.php');
require_once('./model/item.php');

class itemDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getItem($itemId){
        $query = 'SELECT * FROM items WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $item = new Item($temp['id'],$temp['name'], $temp['quantity'], $temp['description'], $temp['purchase_date'], $temp['image']);
            $result->free();
            return $item;
        }
        $result->free();
        return false;
    }


    public function getItems(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM items');
        $items = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new item object, and add it to the array.
                $item = new Item($row['id'], $row['name'], $row['quantity'], $row['description'], $row['purchase_date'], $row['image']);
                $items[] = $item;
            }
            $result->free();
            return $items;
        }
        $result->free();
        return false;
    }   
    
    public function addItem($item){        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a placeholder for the parameters to be used
            //in the query. The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO items (name, quantity, description, purchase_date, image) VALUES (?,?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $name = $item->getName();
                    $quantity = $item->getQuantity();
			        $description = $item->getDescription();
			        $purchase_date = $item->getPurchaseDate();
                    $image = $item->getImage();
                  
			        $stmt->bind_param('sisss', 
				        $name, 
                        $quantity,
				        $description,
				        $purchase_date, 
                        $image
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $item->getName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }  

    public function updateItem($item){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a placeholder for the parameters to be used
            //in the query. The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized query as a parameter.
            $query = "UPDATE items SET name=?, quantity=?, description=?, purchase_date=?, image=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $item->getId();
                    $name = $item->getName();
                    $quantity = $item->getQuantity();
			        $description = $item->getDescription();
			        $purchase_date = $item->getPurchaseDate();
                    $image = $item->getImage();
                  
			        $stmt->bind_param('sisssi', 
				        $name, $quantity,
				        $description,
				        $purchase_date, $image,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $item->getName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteItem($itemId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM items WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $itemId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>