<?php

namespace yarf\Database;

class Collection
{
    private $models = array();

    function __construct()
    {
    }

    public function only()
    {
        $args = func_get_args();
        $return = array();

        foreach ($this->models as $model) 
        {
            $entry = array();
            foreach ($args as $filter) 
            {
                $entry[$filter] = $model[$filter];
            }

            if(empty($entry)) {
                throw new \Exception("A model in the collection did not contain any of the filtered attributes");
            }

            array_push($return, $entry);
        }

        return $return;
    }

    public function except()
    {
        $args = func_get_args();
        $return = array();

        foreach ($this->models as $model) 
        {
            $entry = array();
            $attribs = $model->getKeys(); // actual model class will need to work with array_keys

            foreach ($attribs as $attrib) 
            {
                if(!in_array($attrib, $args)) {
                    $entry[$attrib] = $model[$attrib];
                } else {
                    // it's in the array, don't want this attribute
                }
            }

            if(empty($entry)) {
                throw new \Exception("A model in the collection filtered to empty using the except filter");
            }

            array_push($return, $entry);
        }

        return $return;
    }

    public function isEmpty()
    {
        return count($this->models) == 0;
    }

    public function addModel($model)
    {
        array_push($this->models, $model);
    }

    public function getModels()
    {
        return $this->models;
    }

}
