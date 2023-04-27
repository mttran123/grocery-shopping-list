<?php
	class Item {		

		private $id;
		private $name;
		private $quantity;
		private $description;
		private $purchaseDate;
		private $imageFile;
				
		function __construct($id, $name, $quantity, $description, $purchaseDate, $imageFile){
			$this->setId($id);
			$this->setName($name);
			$this->setQuantity($quantity);
			$this->setDescription($description);
			$this->setPurchaseDate($purchaseDate);
			$this->setImage($imageFile);
		}		

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}

		public function getQuantity(){
			return $this->quantity;
		}

		public function setQuantity($quantity) {
			$this->quantity = $quantity;
		}
		
		public function getDescription(){
			return $this->description;
		}

		public function setDescription($description) {
			$this->description = $description;
		}

		public function getPurchaseDate(){
			return $this->purchaseDate;
		}

		public function setPurchaseDate($purchaseDate){
			$this->purchaseDate = $purchaseDate;
		}

		public function setImage($imageFile){
			$this->imageFile = $imageFile;
		}

		public function getImage(){
			return $this->imageFile;
		}

	}
?>