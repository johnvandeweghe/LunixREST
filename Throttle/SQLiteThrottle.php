<?php
namespace LunixREST\Throttle;

use LunixREST\Request\Request;

/**
 * Use SQLite as a backend for throttling requests
 * Class SQLiteThrottle
 * @package LunixREST\Throttle
 */
abstract class SQLiteThrottle implements Throttle {
    /**
     * @var
     */
    protected $limit;
    /**
     * @var \SQLite3
     */
    protected $db;

    /**
     * @param $file
     * @param $limitPerMinute
     */
    public function __construct($file, $limitPerMinute){
        $this->db = new \SQLite3($file);

        $result = $this->db->query('SELECT name FROM sqlite_master');
        if(!($row = $result->fetchArray()) || $row['name'] != 'throttle'){
            $this->db->exec('CREATE TABLE throttle (key STRING, count NUMBER, lastMinute NUMBER)');
        }
        $this->limit = $limitPerMinute;
    }

    /**
     * @param \LunixREST\Request\Request $request
     * @return bool
     */
    public abstract function throttle(Request $request);

    /**
     * @param $key
     * @return bool
     */
    protected function genericThrottle($key){
        $minute = ceil(time() / 60);
        if($result = $this->db->querySingle('SELECT key, count, lastMinute FROM throttle WHERE key = ' . \SQLite3::escapeString($key), true)) {
            if($result['lastMinute'] == $minute){
                if($result['count'] + 1 <= $this->limit){
                    $this->db->query('UPDATE throttle SET count = ' . ($result['count'] + 1) . ' WHERE key = ' . \SQLite3::escapeString($key));
                } else {
                    return true;
                }
            } else {
                $this->db->query('UPDATE throttle SET lastMinute = ' . $minute . ', count = 1 WHERE key = ' . \SQLite3::escapeString($key));
            }
        } else {
            $this->db->query('INSERT INTO throttle (key, count, lastMinute) VALUES (' . \SQLite3::escapeString($key) . ', 1, ' . $minute . ')');
        }
        return false;
    }
}