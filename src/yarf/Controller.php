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

        if(!empty($controller['args']) && gettype($controller['args'][0]) == 'string' ) {
            $collection = $this->getCollection($controller['args'][0]);
        } else {
            $collection = $this->getCollection();
        }

        assert('is_callable($function)');
        if($this->matchesAcceptType($type)) {
            // call function
            return call_user_func_array($function, array($collection));
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
            if($stmt->execute($args)) {
                while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $return->addModel($row);
                }

                return $return;
            }

        } else {
            $stmt = $dbh->prepare('SELECT * FROM ' . $table);
            if($stmt->execute()) {
                while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $return->addModel($row);
                }

                return $return;
            }
        }

        return false;

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
