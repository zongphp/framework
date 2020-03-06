<?php namespace {{NAMESPACE}};

use zongphp\database\build\Seeder;
use zongphp\db\Db;

class {{className}} extends Seeder {
    //执行
	public function up() {
		//Db::table('news')->insert(['title'=>'ZongPHP']);
    }
    //回滚
    public function down() {

    }
}