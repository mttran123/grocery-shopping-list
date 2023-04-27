--
-- Database: `demo` and php web application user
CREATE DATABASE demo;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON demo.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE demo;
--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `quantity` int(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `purchase_date` DATE NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
  

--
-- Inserting data for table `items`
--

INSERT INTO `items` (`id`, `name`, `quantity`, `description`, `purchase_date`, `image`) VALUES
(1, 'Apple', 3, 'red crispy apples', '2023-03-03', 'apple'),
(2, 'Banana', 10, 'yellow banana', '2023-03-03', 'banana'),
(3, 'Milk', 2, '2% milk container', '2023-03-03', 'milk');

