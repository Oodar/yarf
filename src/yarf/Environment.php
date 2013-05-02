<?php

namespace yarf;

use Symfony\Component\Yaml\Yaml;
use Yarf\http\Response;

class Environment
{
    private $dbh;
    private $settings = array();

    function __construct()
    {
        $this->parseEnvironmentSettings();
    }

    public function parseEnvironmentSettings()
    {
        // read in from YAML
        $yaml = Yaml::parse(__DIR__ . '/yarf.yml');
        $this->settings = $yaml;
    }

    public function getAcceptedTypes()
    {
        if(isset($_SERVER['HTTP_ACCEPT'])) {
            return explode(',',$_SERVER['HTTP_ACCEPT']);
        } else {
            return array();
        }
    }

    public function getDatabaseHandle() {
        if(isset($this->dbh)) {
            return $this->dbh;
        } else {
            throw new \Exception('Database handle not set');
        }
    }

    public function connectToDatabase()
    {
        $db = $this->getDatabaseSettings();

        try {
            $this->dbh = new \PDO('mysql:host='.$db['host'].';dbname='.$db['db'], $db['user'], $db['password']);
            return true;
        } catch (PDOException $e) {
            // failed
        }
    }

    public function getDatabaseSettings()
    {
        return $this->settings['database'];
    }
}
