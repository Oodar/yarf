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
        // you'd still have to actually get the collection passed into the closure somehow
        // this has to happen here, magically
        // figure out if there were arguments to the function, could infer an id from that
        $collection = $this->getCollection();

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
        // controllers file names are named after the object(s) they represent, a la RoR.
        $class = get_class($this);
        $table = strtolower(Inflection::pluralize($class));

        $dbh = $this->env->getDatabaseHandle();

        $stmt = $dbh->prepare('SELECT * FROM ' . $table);
        $return = new Collection();

        if($stmt->execute()) {
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $return->addModel($row);
            }
            return $return;
        } else {
        }

        return false;

    }

    private function matchesAcceptType($type)
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
