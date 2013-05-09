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
    public function collection($res)
    {
        $this->respondTo('json', function($collection) {
            echo $collection->except('id', 'name')->toJSON();
        });

        $this->respondTo('html', function($collection) {
            echo $collection->except('id', 'name')->toJSON();
        });
    }

    // Mapped to GET against a single example (/example/:id)
    public function collectionById($id, $res)
    {
        $this->respondTo('json', function($collection) {
            echo $collection->except('id')->toJSON();
        });

        $this->respondTo('html', function($collection) {
            echo $collection->except('id')->toJSON();
        });
    }

    // Mapped to PUT update
    public function updateById($id, $res)
    {
        $this->respondTo('json', function($collection, $payload) {
            $model = array_pop($collection->getModels());
            if($model->hasUpdate($payload)) {
                echo json_encode(array("update" => "true"));
            } else {
                echo json_encode(array("update" => "false"));
            }
        });

        $this->respondTo('html', function($collection, $payload) {
            echo json_encode($collection->getModels());
        });
    }
}
?>