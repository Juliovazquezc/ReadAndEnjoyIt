<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;

class UpdateModelUtil
{
    
    /**
     * Update model attributes from a http put request
     * 
     * @param Model $model
     * @param array $data
     * 
     * @return Model
     */
    public function __invoke(Model $model, array $data): Model {
        foreach($data as $key => $attribute) {
            $model->{$key} = $attribute;
        }
        $model->save();
        return $model;
    }
}