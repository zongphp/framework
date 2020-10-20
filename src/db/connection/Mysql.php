<?php
namespace zongphp\db\connection;

class Mysql implements DbInterface {
	use Connection;

	/**
	 * pdo连接
	 *
	 * @return string
	 */
	public function getDns() {
		return $dns = 'mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['database'];
	}
}