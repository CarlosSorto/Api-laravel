<?php

namespace Iw\Api\Forms;

use Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class BaseForm
{
    public function __construct($model, $transformer, $params)
    {
        $this->transformer = $transformer;
        $this->model = $model;
        $this->errors = null;
        $this->params = $params;

        $class = get_class($this->model);
        $this->class = $class;
        $this->data = $class::parseData($this->params);
    }

    public function sync()
    {
        $errors = [];

        $data = $this->data;
        $class = $this->class;
        $validator = $this->validator($data);
        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        } else {
            $this->persist();
            $identifier = $this->model->{$class::identifierAttribute()};
            $this->model = $class::findByIdentifier($identifier)->search($this->params)->first();

            return true;
        }
    }

    protected function persist()
    {
    }

    protected function validator($data)
    {
        $options = [];
        return $validator = Validator::make($data, $options);
    }
}
