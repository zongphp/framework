<?php namespace {{NAMESPACE}};
use zongphp\database\build\Migration;
use zongphp\database\build\Blueprint;
use zongphp\database\Schema;
class {{className}} extends Migration {
    //执行
	public function up() {
		Schema::create( '{{TABLE}}', function ( Blueprint $table ) {
			$table->increments( 'id' );
            $table->timestamps();
        });
    }

    //回滚
    public function down() {
        Schema::drop( '{{TABLE}}' );
    }
}