<?php
namespace zongphp\db\connection;

class Mysql implements DbInterface
{
    use Connection;

    /**
     * PDO连接
     *
     * @return string
     */
    public function getDns()
    {
        return $dns = 'mysql:dbname='.$this->config['database'].';host='.$this->config['host'].';port='.$this->config['port'];
    }
}