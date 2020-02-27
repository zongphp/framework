<?php
namespace zongphp\cli\build\migrate;

use zongphp\cli\build\Base;

class Migrate extends Base {
	//当前执行的数据库中的编号
	protected static $batch;

	public function __construct() {
		if ( ! Schema::tableExists( 'migrations' ) ) {
			$sql = "CREATE TABLE " . c( 'database.prefix' ) . 'migrations(migration varchar(255) not null,batch int)CHARSET UTF8';
			Db::execute( $sql );
		}

		if ( empty( self::$batch ) ) {
			self::$batch = Db::table( 'migrations' )->max( 'batch' ) ?: 0;
		}
	}

	//执行迁移
	public function make() {
		$files = glob( ROOT_PATH . '/system/database/migrations/*.php' );
		sort( $files );
		foreach ( (array) $files as $file ) {
			$name = substr( basename( $file ), 0, -24);
			//只执行没有执行过的migration
			if ( ! Db::table( 'migrations' )->where( 'migration', basename($file) )->first() ) {
				require $file;
				$class = 'system\database\migrations\\' . $name;
				( new $class )->up();
				Db::table( 'migrations' )->insert( [ 'migration' => basename($file), 'batch' => self::$batch + 1 ] );
			}
		}
	}

	//回滚到上次迁移
	public function rollback() {
		$batch = Db::table( 'migrations' )->max( 'batch' );
		$files = Db::table( 'migrations' )->where( 'batch', $batch )->lists( 'migration' );
		foreach ( (array) $files as $f ) {
			$file = ROOT_PATH . '/system/database/migrations/' . $f;
			if ( is_file( $file ) ) {
				require $file;
				$class = 'system\database\migrations\\' . substr( basename( $file ), 0, - 24 );
				( new $class )->down();
			}
			Db::table( 'migrations' )->where( 'migration', $f )->delete();
		}
	}

	//迁移重置
	public function reset() {
		$files = Db::table( 'migrations' )->lists( 'migration' );
		foreach ( (array) $files as $f ) {
			$file = ROOT_PATH . '/system/database/migrations/' . $f . '.php';
			if ( is_file( $file ) ) {
				require $file;
				$class = 'system\database\migrations\\' . substr( basename( $file ), 18, - 4 );
				( new $class )->down();
			}
			Db::table( 'migrations' )->where( 'migration', $f )->delete();
		}
	}
}