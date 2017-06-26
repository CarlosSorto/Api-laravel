<?php
namespace Iw\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Support\Facades\Lang;

class ErrorTransformer extends TransformerAbstract
{
    public function transform($status)
    {
        $data = ['data' => null, 'errors' => ["base"=>trans("iw.api.errors.internal_server_error")]];
        switch ($status) {
          case 400:
              $data["errors"]["base"] = [trans("iw.api.errors.bad_request")];
              break;
          case 401:
              $data["errors"]["base"] = [trans("iw.api.errors.unauthorized")];
              break;
          case 403:
              $data["errors"]["base"] = [trans("iw.api.errors.forbidden")];
              break;
      }
        return $data;
    }
}
