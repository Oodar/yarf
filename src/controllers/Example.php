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

    
    // Mapped to GET against whole /example collection
    public function collection()
    {
        $this->respondTo('json', function($collection) {
            echo json_encode($collection->getModels());
        });

        $this->respondTo('html', function($collection) {
            echo json_encode($collection->getModels());
        });
    }

    // Mapped to GET against a single example (/example/:id)
    public function collectionById($id)
    {
        $this->respondTo('html', function($collection) {
            echo json_encode($collection->getModels());
        });
    }

    // Mapped to PUT update
    public function updateById($id)
    {
        $this->respondTo('json', function($collection) {
            echo json_encode($collection->getModels());
        });

        $this->respondTo('html', function($collection) {
            echo json_encode($collection->getModels());
        });
    }
}

?>