<?php

namespace yarf;

use yarf\Util\Inflection;
use yarf\Environment;
use yarf\Database\Collection;

class Controller
{
    protected $respondTypes = array();
    protected $env;

    function __construct()
    {
        $this->env = new Environment();
        $this->env->connectToDatabase();
    }

    public function respondTo($type, $function)
    {
        // pass any arguments that were given the the controllers function over to the getCollection function
        // we're assuming this is an id reference into the table that the Controller represents
        $trace = debug_backtrace();
        $controller = $trace[1];

        // get any payload data
        $payload = $this->getPayload();

        if(!empty($controller['args']) && gettype($controller['args'][0]) == 'string' ) {
            $collection = $this->getCollection($controller['args'][0]);
        } else {
            $collection = $this->getCollection();
        }

        assert('is_callable($function)');
        if($this->matchesAcceptType($type)) {
            // call function
            return call_user_func_array($function, array($collection, $payload));
        } else {
            // don't call function
            return false;
        }
    }

    protected function getCollection()
    {
        $args = func_get_args();

        // controllers file names are named after the object(s) they represent, a la RoR.
        $class = get_class($this);
        $table = strtolower(Inflection::pluralize($class));

        $dbh = $this->env->getDatabaseHandle();


        $return = new Collection();

        if(!empty($args)) {
            $stmt = $dbh->prepare('SELECT * FROM ' . $table . ' WHERE id=?');

            // set the fetch mode
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'yarf\Database\Model');

            if($stmt->execute($args)) {
                while($row = $stmt->fetch()) {
                    $return->addModel($row);
                }
                return $return;
            } 
        } else {
            $stmt = $dbh->prepare('SELECT * FROM ' . $table);

            // set the fetch mode
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'yarf\Database\Model');

            if($stmt->execute()) {

                while($row = $stmt->fetch()) {
                    $return->addModel($row);
                }

                return $return;
            }         
        }

        return false;

    }

    protected function getPayload()
    {
        // only support JSON at this time
        return json_decode(file_get_contents('php://input'), true);
    }

    protected function matchesAcceptType($type)
    {
        $accept = $this->env->getAcceptedTypes();

        foreach ($accept as $acceptType) {

            if(strstr($acceptType, $type)) {
                return true;
            }
        }

        return false;
    }
}
