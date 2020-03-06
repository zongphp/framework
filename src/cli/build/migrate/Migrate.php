<?php
namespace zongphp\cli\build\migrate;

use zongphp\cli\build\Base;
use zongphp\config\Config;
use zongphp\database\Schema;
use zongphp\db\Db;

class Migrate extends Base
{
    protected $namespace;

    //当前执行的数据库中的编号
    protected static $batch;

    public function __construct()
    {
        $this->namespace = str_replace('/', '\\', self::$path['migration']);
        if ( ! Schema::tableExists('migrations')) {
            $sql = "CREATE TABLE ".Config::get('database.prefix')
                   .'migrations(migration varchar(255) not null,batch int)CHARSET UTF8';
            Db::execute($sql);
        }
        if (empty(self::$batch)) {
            self::$batch = Db::table('migrations')->max('batch') ?: 0;
        }
    }

    /**
     * 执行迁移
     *
     * @return bool
     */
    public function run()
    {
        return $this->make();
    }

    /**
     * 执行迁移
     *
     * @return bool
     */
    public function make()
    {
        $files = glob(self::$path['migration'].'/*.php');
        sort($files);
        foreach ((array)$files as $file) {
            //只执行没有执行过的migration
            if ( ! Db::table('migrations')->where('migration', basename($file))->first()) {
                $info  = pathinfo($file);
                $class = $this->namespace.'\\'.$info['filename'];
                if (class_exists($class)) {
                    (new $class)->up();
                    Db::table('migrations')->insert(
                        [
                            'migration' => basename($file),
                            'batch'     => self::$batch + 1,
                        ]
                    );
                }
            }
        }
        if (defined('RUN_MODE') && RUN_MODE != 'CLI') {
            return true;
        }
    }

    /**
     * 回滚到上次迁移
     *
     * @return bool
     */
    public function rollback()
    {
        $batch = Db::table('migrations')->max('batch');
        $files = Db::table('migrations')->where('batch', $batch)->lists('migration');
        foreach ((array)$files as $f) {
            $file = self::$path['migration'].'/'.$f;
            if (is_file($file)) {
                $info  = pathinfo($file);
                $class = $this->namespace.'\\'.$info['filename'];
                (new $class)->down();
            }
            Db::table('migrations')->where('migration', $f)->delete();
        }
        if (defined('RUN_MODE') && RUN_MODE != 'CLI') {
            return true;
        }
    }

    /**
     * 迁移重置
     *
     * @return bool
     */
    public function reset()
    {
        $files = Db::table('migrations')->lists('migration');
        foreach ((array)$files as $f) {
            $file = self::$path['migration'].'/'.$f;
            if (is_file($file)) {
                $info  = pathinfo($file);
                $class = $this->namespace.'\\'.$info['filename'];
                (new $class)->down();
            }
            Db::table('migrations')->where('migration', $f)->delete();
        }
        if (defined('RUN_MODE') && RUN_MODE != 'CLI') {
            return true;
        }
    }
}