<?php

namespace Iw\Api\Traits\Http\Controllers;

use Illuminate\Http\Request;

trait ResourcesController
{
    use \Iw\Api\Traits\Http\JsonResponders;

    public function index(Request $request)
    {
        $search = $this->repository->search($request);
        $paginator = $this->repository->paginate($search, $request);
        $models = $search->get();

        return response()->json(
         $this->jsonCollection(
           $models,
           $this->repository->transformer(),
           $paginator
           )
       );
    }

    public function create(Request $request)
    {
        $form = $this->repository->form($request);
        if ($form->sync() == true) {
            return response()->json($this->jsonItem($form->model, $form->transformer));
        } else {
            return response()->json($this->jsonError(422, $form->errors));
        }
    }

    public function update($uuid = null, Request $request)
    {
        $form = $this->repository->form($request, $uuid);
        if ($form->sync() == true) {
            return response()->json($this->jsonItem($form->model, $form->transformer));
        } else {
            return response()->json($this->jsonError(422, $form->errors));
        }
    }

    public function show($uuid = null, Request $request)
    {
        $model =  $this->repository->find($uuid, $request);

        if (empty($model)) {
            return response()->json($this->jsonError(422, ['base'=> trans("api_auth::validation.resource_exists")]));
        } else {
            return response()->json($this->jsonItem($model,  $this->repository->transformer()));
        }
    }

    public function destroy($uuid = null, Request $request)
    {
        $model =  $this->repository->find($uuid, $request);

        if (empty($model)) {
            return response()->json($this->jsonError(422, ['base'=> trans("api_auth::validation.resource_exists")]));
        } else {
            $model->delete();
            return response()->json($this->jsonItem($model,  $this->repository->transformer()));
        }
    }
}
