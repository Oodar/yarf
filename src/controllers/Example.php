<?php 

/**
 * Example Controller for testing purposes
 */

use yarf\Controller;

class Example extends Controller
{
    
    function __construct()
    {
        parent::__construct();
    }

    
    public function collection()
    {
        $this->respondTo('json', function($collection) {
            echo json_encode($collection->getModels());
        });

        $this->respondTo('html', function($collection) {
            echo json_encode($collection->getModels());
        });
    }

    public function collectionById($id)
    {
        $this->respondTo('html', function($collection) {
            echo json_encode($collection->except());
        });
    }
}

?>