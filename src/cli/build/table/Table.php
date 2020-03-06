<?php
namespace zongphp\cli\build\table;

use zongphp\cli\build\Base;
use zongphp\config\Config;
use zongphp\database\Schema;

class Table extends Base
{
    //创建缓存表
    public function cache()
    {
        $table = Config::get('database.prefix').Config::get('cache.mysql.table');
        if (Schema::tableExists(c('cache.mysql.table'))) {
            $this->error('Table already exists');
        }
        $sql
            = <<<sql
CREATE TABLE `{$table}` (
  `name` char(20) DEFAULT NULL,
  `data` mediumtext,
  `create_at` int(10),
  `expire` int(10),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
sql;
        Schema::sql($sql);
    }
}