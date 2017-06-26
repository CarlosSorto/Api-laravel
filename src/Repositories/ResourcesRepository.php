<?php
namespace Iw\Api\Repositories;

trait ResourcesRepository
{
    public function modelClass()
    {
        $model = null;
        return $model;
    }

    public function formClass()
    {
        $model = null;
        return $model;
    }

    public function transformerClass()
    {
        $model = null;
        return $model;
    }

    public function build()
    {
        $model = $this->modelClass();
        $return = new $model;
        return $return;
    }

    public function find($identifier, $params)
    {
        $model = $this->modelClass();
        return $model::findByIdentifier($identifier)->search($params)->first();
    }

    public function search($params)
    {
        $model = $this->modelClass();
        return $model::search($params);
    }

    public function paginate($search, $params)
    {
      $model = $this->modelClass();
      return $model::paginateSearch($search, $params);
    }

    public function form($params, $identifier = null)
    {
        $formClass = $this->formClass();
        if (empty($identifier)) {
            $model = $this->build();
        } else {
            $model = $this->find($identifier, $params);
        }

        $form = new $formClass(
          $model,
          $this->transformer(),
          $params
        );

        return $form;
    }

    public function transformer()
    {
        $transformerClass = $this->transformerClass();
        $transformer = new $transformerClass();
        return $transformer;
    }
}
