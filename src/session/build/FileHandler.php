<?php
namespace zongphp\session\build;
use zongphp\config\Config;

/**
 * 文件处理
 * Class FileHandler
 */
class FileHandler implements AbSession {
	use Base;
	protected $dir;
	protected $file;

	//连接
	public function connect() {
		$dir = Config::get( 'session.file.path' );
		//创建目录
		if ( ! is_dir( $dir ) ) {
			mkdir( $dir, 0755, true );
			file_put_contents( $dir . '/index.html', '' );
		}
		$this->dir = realpath( $dir );

		$this->file = $this->dir . '/' . $this->session_id . '.php';
	}

	//读取数据
	public function read() {
		if ( ! is_file( $this->file ) ) {
			return [ ];
		}

		return include $this->file;
	}

	//保存数据
	public function write() {
		$data = "<?php \nreturn " . var_export( $this->items, true ) . ";\n?>";
		file_put_contents( $this->file, $data );
	}

	//垃圾回收
	public function gc() {
		foreach ( glob( $this->dir . '/*.php' ) as $f ) {
			if ( basename( $f ) != basename( $this->file ) && ( filemtime( $f ) + $this->expire+1440 ) < time() ) {
				unlink( $f );
			}
		}
	}
}