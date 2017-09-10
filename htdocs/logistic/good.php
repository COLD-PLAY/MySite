<?php
include_once('conn.php');

class good {
	private $goodname;
	private $goodnum;
	private $ordernum;
	private $fromuser;
	private $touser;
	private $status;

	private $conn;

	private $flag;

	public function getgoodname() {
		return $this->goodname;
	}
	public function getflag() {
		return $this->flag;
	}
	public function __construct() {
		$num = func_num_args();
		$args = func_get_args();

		if ($num == 6) {
			$this->goodname = $args[0];
			$this->goodnum = $args[1];
			$this->ordernum = $args[2];
			$this->fromuser = $args[3];
			$this->touser = $args[4];
			$this->status = $args[5];

			$this->flag = true;
		}
		elseif ($num == 1) {
			$this->ordernum = $args[0];
			$result = $this->getGoodInfo();

			if ($result) {
				$this->goodname = $result['goodname'];
				$this->goodnum = $result['goodnum'];
				$this->fromuser = $result['fromuser'];
				$this->touser = $result['touser'];
				$this->status = $result['status'];

				$this->flag = true;
			}
			else {
				$this->flag = false;
			}
		}
	}

	public function getGoodInfo() {
		$sql = "SELECT * FROM goods WHERE ordernum='$this->ordernum'";

		$this->start();
		if ($this->conn) {
			$result = $this->conn->query($sql)->fetch();
			$this->close();
			return $result;
		}
		return null;
	}

	public function insert() {
		$sql = "INSERT INTO goods VALUES('$this->goodname', '$this->goodnum', '$this->ordernum', '$this->fromuser', '$this->touser', '$this->status')";

		if ($this->conn) {
			$this->conn->exec($sql);
			return true;
		}
		return false;
	}

	public function delete() {
		$sql = "DELETE FROM goods WHERE ordernum='$this->ordernum'";

		if ($this->conn) {
			$this->conn->exec($sql);
			return true;
		}
		return false;
	}

	public function start() {
		$orderconn = new conn();
		$this->conn = $orderconn->getConn();
	}

	public function close() {
		$this->conn = null;
	}
}
?>