<?php
namespace zongphp\cli\build\table;

use zongphp\cli\build\Base;

class Table extends Base {
	//创建缓存表
	public function cache() {
		$table = c( 'database.prefix' ) . c( 'cache.mysql.table' );
		if ( Schema::tableExists( c( 'cache.mysql.table' ) ) ) {
			$this->error( 'Table already exists' );
		}
		$sql
			= <<<sql
CREATE TABLE `{$table}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) DEFAULT NULL,
  `data` mediumtext,
  `create_at` int(10),
  `expire` int(10),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
sql;
		Schema::sql( $sql );
	}
}