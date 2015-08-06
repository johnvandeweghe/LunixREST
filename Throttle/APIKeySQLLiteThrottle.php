<?php
namespace LunixREST\Throttle;

class APIKeySQLLiteThrottle implements Throttle {
    protected $limit;
    protected $db;

    public function __construct($file, $limitPerMinute){
        $this->db = new \SQLite3($file);

        $result = $this->db->query('SELECT name FROM sqlite_master');
        if(!($row = $result->fetchArray()) || $row['name'] != 'throttle'){
            $this->db->exec('CREATE TABLE throttle (apiKey STRING, count NUMBER, lastMinute NUMBER)');
        }
        $this->limit = $limitPerMinute;
    }

    /**
     * @param $apiKey
     * @param $endPoint
     * @param $method
     * @return bool
     */
    public function throttle($apiKey, $endPoint, $method)
    {
        $minute = ceil(time() / 60);
        if($result = $this->db->querySingle('SELECT apiKey, count, lastMinute FROM throttle WHERE apiKey = ' . \SQLite3::escapeString($apiKey), true)) {
            if($result['lastMinute'] == $minute){
                if($result['count'] + 1 <= $this->limit){
                    $this->db->query('UPDATE throttle SET count = ' . ($result['count'] + 1) . ' WHERE apiKey = ' . \SQLite3::escapeString($apiKey));
                } else {
                    return true;
                }
            } else {
                $this->db->query('UPDATE throttle SET lastMinute = ' . $minute . ', count = 1 WHERE apiKey = ' . \SQLite3::escapeString($apiKey));
            }
        } else {
            $this->db->query('INSERT INTO throttle (apiKey, count, lastMinute) VALUES (' . \SQLite3::escapeString($apiKey) . ', 1, ' . $minute . ')');
        }
        return false;
    }
}