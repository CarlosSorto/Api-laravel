<?php

namespace Iw\Api\Traits\Http;

use Iw\Api\Transformers\ErrorTransformer;
use League\Fractal\Serializer\ArraySerializer;

trait JsonResponders
{
    protected function jsonCollection($data, $transformer, $paginator = null, $meta = [])
    {
        $fractal = fractal();
        $transformed = $fractal->collection($data, $transformer)->toArray();
        $transformed["meta"] = $meta;
        if (is_object($paginator)) {
            $transformed["meta"]["current_page"] = $paginator->currentPage();
            $transformed["meta"]["per_page"] = $paginator->perPage();
            $transformed["meta"]["total"] = $paginator->total();
        }

        return $transformed;
    }

    protected function jsonItem($data, $transformer, $meta = [])
    {
        $fractal = fractal();
        $transformed = $fractal->item($data, $transformer)->toArray();
        $transformed["meta"] = $meta;
        return $transformed;
    }

    protected function jsonError($status, $errors = null, $meta = [])
    {
        $fractal = fractal();
        $fractal->serializeWith(new ArraySerializer());
        $transformed = $fractal->item($status, new ErrorTransformer)->toArray();
        if ($errors) {
            $transformed["errors"] = $errors;
        }
        $transformed["meta"] = $meta;
        return $transformed;
    }
}
