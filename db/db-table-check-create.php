<?php
require "connection.php";

class tableCheck extends database{

	public function checkUserPresent(){
		$sql="SELECT * FROM user ";
		$result=$this->connect()->query($sql);
		if ($result) {
			if ($result->num_rows>0) {
				return "user";
			}
		}else{ return "no-user";}
	}

	public function createTable(){
		$table=0;
		$table_insert=0;

		$sql_create_user="CREATE TABLE `user` (
			`id` bigint(10) NOT NULL AUTO_INCREMENT,
			`username` varchar(100) NOT NULL,
			`password` varchar(255) NOT NULL,
			`email` varchar(225) NOT NULL,
			`last_login` datetime NOT NULL,
			`count_login` int(10) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `username` (`username`),
			UNIQUE KEY `email` (`email`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		if ($this->connect()->query($sql_create_user) === TRUE) {
			$table=$table+1;
		}

		$sql_create_sales="CREATE TABLE `sales` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`inv_id` int(11) NOT NULL,
			`ph_id` int(11) NOT NULL,
			`qyt` int(11) NOT NULL,
			`mrp` double NOT NULL,
			`total_mrp` double NOT NULL,
			`item_name` varchar(225) NOT NULL,
			`card` int(11) NOT NULL COMMENT 'card(1):added to card, card(0):sales process done and add to card_process_sale table, card(2):sales cancel',
			`sales_date` datetime NOT NULL DEFAULT current_timestamp(),
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		if ($this->connect()->query($sql_create_sales) === TRUE) {
			$table=$table+1;
		}

		$sql_create_purch="CREATE TABLE `purchase` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`inv_id` int(11) NOT NULL,
			`date` date NOT NULL,
			`qyt` int(11) NOT NULL,
			`qyt_purch` int(11) NOT NULL,
			`bill_no` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		if ($this->connect()->query($sql_create_purch) === TRUE) {
			$table=$table+1;
		}

		$sql_create_inventory="CREATE TABLE `inventory` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`code` varchar(225) NOT NULL,
			`item_name` varchar(225) NOT NULL,
			`batch_no` varchar(225) NOT NULL,
			`expire_date` date NOT NULL,
			`mrp` double NOT NULL,
			`qyt` int(11) NOT NULL,
			`qyt_purch` int(11) NOT NULL,
			`return_exp` int(11) NOT NULL,
			`return_date` date NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		if ($this->connect()->query($sql_create_inventory) === TRUE) {
			$table=$table+1;
		}

		$sql_create_cardPS="CREATE TABLE `card_processed_sale` (
  			`id` int(10) NOT NULL AUTO_INCREMENT,
  			`all_sales_item_id` varchar(225) NOT NULL,
  			`total_amo` double NOT NULL,
  			`disount_percent` int(10) NOT NULL,
  			`total_net_amo` double NOT NULL,
  			`process_date` datetime NOT NULL DEFAULT current_timestamp(),
  			`customer_name` varchar(225) NOT NULL,
  			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		if ($this->connect()->query($sql_create_cardPS) === TRUE) {
			$table=$table+1;
		}

		
    	$sql='INSERT INTO user(username,password,email,last_login,count_login) values("santosh","$2y$10$dV4Pmit4rcMNxnFG9yIW9umsNRs1MUMHdt3ms7w22cWZFUs6lnTHS","santosh@g.com","0",0)';
        $result=$this->connect()->query($sql);
    	if ($result) {
      		$table_insert=1;
    	}

		$return_result=$table+$table_insert;
		return $return_result;
	}

}


