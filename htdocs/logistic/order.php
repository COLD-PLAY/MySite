<?php
include_once('conn.php');
class order {
	private $fromuser;
	private $fromphonenum;
	private $fromaddress;
	private $touser;
	private $tophonenum;
	private $toaddress;
	private $ordernum;
	private $status;
	private $goodname;
	private $goodnum;

	private $conn;

	private $flag;

	public function getfromuser() {
		return $this->fromuser;
	}
	public function getflag() {
		return $this->flag;
	}
	public function __construct() {
		$num = func_num_args();
		$args = func_get_args();

		if ($num == 8) {
			$this->fromuser = $args[0];
			$this->fromphonenum = $args[1];
			$this->fromaddress = $args[2];
			$this->touser = $args[3];
			$this->tophonenum = $args[4];
			$this->toaddress = $args[5];
			$this->ordernum = $args[6];
			$this->status = $args[7];
			$this->goodname = $args[8];
			$this->goodnum = $args[9];

			$this->flag = true;
		}
		elseif ($num == 1) {
			$this->ordernum = $args[0];
			$result = $this->getOrderInfo();

			if ($result) {
				$this->fromuser = $result['fromuser'];
				$this->fromphonenum = $result['fromphonenum'];
				$this->fromaddress = $result['fromaddressd'];
				$this->touser = $result['touser'];
				$this->tophonenum = $result['tophonenum'];
				$this->toaddress = $result['toaddress'];

				$this->status = $result['fromaddress'];

				$this->goodname = $result['goodname'];
				$this->goodnum = $result['goodnum'];

				$this->flag = true;
			}
			else {
				$this->flag = false;
			}
		}
	}

	public function getOrderInfo() {
		$sql = "SELECT * FROM orders WHERE ordernum='$this->ordernum'";

		$this->start();
		if ($this->conn) {
			$result = $this->conn->query($sql)->fetch();
			$this->close();
			return $result;
		}
		return null;
	}

	public function start() {
		$orderconn = new conn();
		$this->conn = $orderconn->getConn();
	}

	public function close() {
		$this->conn = null;
	}

	public function insert() {
		$sql = "INSERT INTO orders VALUES('$this->fromuser', '$this->fromphonenum', '$this->fromaddress', '$this->touser', '$this->tophonenum', '$this->toaddress', '$this->ordernum', '$this->status', '$this->goodname', '$this->goodnum')";

		if ($this->conn) {
			$this->conn->exec($sql);
			return true;
		}
		return false;
	}

	public function delete() {
		$sql = "DELETE FROM orders WHERE ordernum='$this->ordernum'";
		$sql1 = "UPDATE `trucks` SET `ordernum`='0', `status`='wait' WHERE ordernum='$this->ordernum'";

		if ($this->conn) {
			$this->conn->exec($sql);
			$this->conn->exec($sql1);
			return true;
		}
		return false;
	}

	public function update($status, $trucknum) {
		$sql = "UPDATE orders SET status='$status' WHERE ordernum='$this->ordernum'";
		$sql1 = "UPDATE `trucks` SET `status`='$status', ordernum='$this->ordernum' WHERE trucknum='$trucknum'";

		if ($this->conn) {
			$this->conn->exec($sql);
			$this->conn->exec($sql1);
			return true;
		}
		return false;
	}
}
?>