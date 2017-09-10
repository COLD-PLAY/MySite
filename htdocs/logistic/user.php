<?php
include_once('conn.php');

// class user extends conn {
class user {
	private $username;
	private $password;
	private $phonenum;
	private $address;
	private $status;

	private $conn;

	function getstatus() {
		return $this->status;
	}
	function getpassword() {
		return $this->password;
	}
	function getusername() {
		return $this->username;
	}
	function getphonenum() {
		return $this->phonenum;
	}
	function getaddress() {
		return $this->address;
	}

	public function __construct() {
		// get the number of parameters
		$num = func_num_args();
		// get the array of parameters
		$args = func_get_args();

		if ($num == 1) {
			$this->username = $args[0];
			$result = $this->getUserInfo();
			
			if ($result) {
				$this->password = $result['password'];
				$this->phonenum = $result['phonenum'];
				$this->address = $result['address'];
				$this->status = true;
			}
			else {
				$this->status = false;
			}
		}
		elseif ($num == 4) {
			$this->username = $args[0];
			$this->password = $args[1];
			$this->phonenum = $args[2];
			$this->address = $args[3];

			$this->status = true;
		}
		else $this->status = false;
	}

	public function start() {
		// create an object of conn and get a connection from function getConn()
		$userconn = new conn();
		$this->conn = $userconn->getConn();
	}

	public function close() {
		$this->conn = null;
	}

	// set user info for instance
	public function getUserInfo() {
		$sql = "SELECT * FROM user WHERE username='$this->username'";

		$this->start();
		if ($this->conn) {
			// only can fetch once because only select one line
			$result = $this->conn->query($sql)->fetch();
			$this->close();
			return $result;
		}
		return null;
	}

	// insert user into table
	public function insert() {
		$sql = "INSERT INTO user VALUES('$this->username', '$this->password', '$this->phonenum', '$this->address')";
		
		if ($this->conn) {
			// insert into table
			$this->conn->exec($sql);
			return true;
		}

		return false;
	}

	// update user from table
	public function update($password, $phonenum, $address) {
		if ($password) $this->password = $password;
		if ($phonenum) $this->phonenum = $phonenum;
		if ($address) $this->address = $address;

		$sql = "UPDATE user SET password='$this->password', phonenum='$this->phonenum', address='$this->address' WHERE username='$this->username'";

		if ($this->conn) {
			$this->conn->exec($sql);
			return true;
		}

		return false;
	}

	// delete user from table
	public function delete() {
		$sql = "DELETE FROM user WHERE username='$this->username'";

		if ($this->conn) {
			$this->conn->exec($sql);
			return true;
		}

		return false;
	}

	// public function delete_byroot($username) {
	// 	$sql = "DELETE FROM user WHERE username='$username'";

	// 	if ($this->conn) {
	// 		$this->conn->exec($sql);
	// 		return true;
	// 	}

	// 	return false;
	// }

	// get the orders about user from orders
	public function getOrders() {
		$sql = "SELECT * FROM orders WHERE fromuser='$this->username' OR touser='$this->username'";

		if ($this->conn) {
			$result = $this->conn->query($sql);
			if ($result->rowCount())
				return $result;
		}
		return null;
	}

	public function getAllOrders() {
		$sql = "SELECT * FROM orders";

		if ($this->conn) {
			$result = $this->conn->query($sql);
			if ($result->rowCount())
				return $result;
		}
		return null;
	}

	public function getAllUsers() {
		$sql = "SELECT * FROM user";

		if ($this->conn) {
			$result = $this->conn->query($sql);
			if ($result->rowCount())
				return $result;
		}
		return null;
	}

	public function getWaitGoods() {
		$sql = "SELECT * FROM orders WHERE status='wait'";

		if ($this->conn) {
			$result = $this->conn->query($sql);
			if ($result->rowCount())
				return $result;
		}
		return null;
	}

	public function getWaitTrucks() {
		$sql = "SELECT * FROM trucks WHERE status='wait'";

		if ($this->conn) {
			$result = $this->conn->query($sql);
			if ($result->rowCount())
				return $result;
		}
		return null;
	}

	public function getWorkTrucks() {
		$sql = "SELECT * FROM trucks WHERE status!='wait'";

		if ($this->conn) {
			$result = $this->conn->query($sql);
			if ($result->rowCount())
				return $result;
		}
		return null;
	}

	public function search($phonenum, $ordernum, $username) {
		$sql = "SELECT * FROM orders WHERE ";

		if ($phonenum) $sql .= "(fromphonenum='$phonenum' OR tophonenum='$phonenum') ";
		elseif ($ordernum) $sql .= "ordernum='$ordernum' ";

		elseif ($username) $sql .= "(fromuser='$username' OR touser='$username')";
		
		if ($this->conn) {
			$result = $this->conn->query($sql);
			if ($result->rowCount())
				return $result;
		}
		return null;
	}
}

?>