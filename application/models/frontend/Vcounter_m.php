<?php
class Vcounter_M extends MY_Model
{
	protected $_table_name = 'visitor_counter';

	function __construct ()
	{
		parent::__construct();
	}

	// Visitor Counter Model
	public function addVisitor()
	{
		$ip           = $this->determineIP();
		$table        = 'visitor_counter';
		$dt           = date("Ymd");
		$tm           = time();
		$online_limit = time() - 1800;

		$query = $this->db->query(
			"INSERT INTO $table (ip, dt, hits, online) VALUES('$ip','$dt','1','$tm') ON DUPLICATE KEY " .
			"UPDATE hits=hits+1, online='$tm';"
		);

		return;
	}

	/* By Grant Burton @ BURTONTECH.COM (11-30-2008): IP-Proxy-Cluster Fix */
	public function checkIP($ip) {
		if (!empty($ip) && ip2long($ip)!=-1 && ip2long($ip)!=false) {
			$private_ips = array (
				array('0.0.0.0','2.255.255.255'),
				array('10.0.0.0','10.255.255.255'),
				array('127.0.0.0','127.255.255.255'),
				array('169.254.0.0','169.254.255.255'),
				array('172.16.0.0','172.31.255.255'),
				array('192.0.2.0','192.0.2.255'),
				array('192.168.0.0','192.168.255.255'),
				array('255.255.255.0','255.255.255.255')
				);

			foreach ($private_ips as $r) {
				$min = ip2long($r[0]);
				$max = ip2long($r[1]);
				if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
			}
			return true;
		} else {
			return false;
		}
	}

	public function determineIP() {

		if (isset($_SERVER["HTTP_CLIENT_IP"])) {
			if ($this->checkIP($_SERVER["HTTP_CLIENT_IP"])) {
				return $_SERVER["HTTP_CLIENT_IP"];
			}
		}

		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
				if ($this->checkIP(trim($ip))) {
					return $ip;
				}
			}
		}

		if (isset($_SERVER["HTTP_X_FORWARDED"])) {
			if ($this->checkIP($_SERVER["HTTP_X_FORWARDED"])) {
				return $_SERVER["HTTP_X_FORWARDED"];
			}
		}

		if (isset($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"])) {
			if ($this->checkIP($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"])) {
				return $_SERVER["HTTP_X_CLUSTER_CLIENT_IP"];
			}
		}

		if (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
			if ($this->checkIP($_SERVER["HTTP_FORWARDED_FOR"])) {
				return $_SERVER["HTTP_FORWARDED_FOR"];
			}
		}

		if (isset($_SERVER["HTTP_FORWARDED"])) {
			if ($this->checkIP($_SERVER["HTTP_FORWARDED"])) {
				return $_SERVER["HTTP_FORWARDED"];
			}
		}

		return $_SERVER["REMOTE_ADDR"];
	}
}