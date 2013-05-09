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

        foreach ($this->models as $model) {

            $diff = array_diff($model->getKeys(), $args);

            foreach ($diff as $key) {
                unset($model[$key]);
            }
        }

        return $this;
    }

    public function except()
    {
        $args = func_get_args();
        $return = array();

        foreach ($this->models as $model) {

            $intersect = array_intersect($model->getKeys(), $args);

            foreach ($intersect as $key) {
                unset($model[$key]);
            }
            
        }

        return $this;
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

    public function toJSON()
    {
        $col = array();

        foreach ($this->models as $model) {
            array_push($col, $model->toArray());
        }

        return json_encode($col);
    }
}
