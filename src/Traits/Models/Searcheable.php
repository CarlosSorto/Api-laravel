<?php

namespace Iw\Api\Traits\Models;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Iw\ApiAuth\Contracts\Repositories\UserRepository;
use \Illuminate\Pagination\Paginator;

trait Searcheable
{
    public static function identifierAttribute()
    {
      return "uuid";
    }

    public static function getIdentifierAttribute()
    {
        $class = get_called_class();
        $model = new $class;

        return $model->getTable() . "." . self::identifierAttribute();
    }

    public function scopefindByIdentifier($query, $identifier)
    {
        return $query->where(static::getIdentifierAttribute(), $identifier);
    }

    public static function scopeSearch($query, $params)
    {
        $filter = static::parseQuery($params);
        $class = get_called_class();
        $model = new $class;

        foreach ($filter as $key => $value) {
            $predicate = last(explode("|", $key));
            $name = explode("|", $key)[0];
            if (
                (is_array(static::$searcheable_fields)  &&
                isset(static::$searcheable_fields[$name]) &&
                is_array(static::$searcheable_fields[$name]) &&
                $value !="" &&
                $value != null) || $predicate == "scp"
            ) {
                if ($predicate == "scp") {
                    $type = null;
                } else {
                    $type = static::$searcheable_fields[$name]["type"];
                }

                $all_types = [
                    "integer",
                    "string",
                    "text",
                    "decimal",
                    "date",
                    "datetime",
                    "time"
                ];
                $string_types = [
                    "string",
                    "text"
                ];
                $boolean_types = [
                    "boolean"
                ];
                $number_dates_times_types = [
                    "integer",
                    "decimal",
                    "date",
                    "datetime",
                    "time"
                ];
                $eq_types = $all_types;
                $in_types = $all_types;
                $is_null_types = $all_types;
                $gt_types = $number_dates_times_types;
                $gteq_types = $number_dates_times_types;
                $lt_types = $number_dates_times_types;
                $lteq_types = $number_dates_times_types;
                $cont_types = $string_types;
                $is_true_types = $boolean_types;
                $is_false_types = $boolean_types;

                switch (true) {
                    case ($predicate == "cont" && in_array($type, $cont_types)):
                        $query->where($model->getTable().".".$name, "like", "%".$value."%");
                        break;
                    case ($predicate == "not_cont" && in_array($type, $cont_types)):
                        $query->where($model->getTable().".".$name, "not like", "%".$value."%");
                        break;
                    case ($predicate == "start" && in_array($type, $cont_types)):
                        $query->where($model->getTable().".".$name, "like", $value."%");
                        break;
                    case ($predicate == "not_start" && in_array($type, $cont_types)):
                        $query->where($model->getTable().".".$name, "not like", $value."%");
                        break;
                    case ($predicate == "end" && in_array($type, $cont_types)):
                        $query->where($model->getTable().".".$name, "like", "%".$value);
                        break;
                    case ($predicate == "not_end" && in_array($type, $cont_types)):
                        $query->where($model->getTable().".".$name, "not like", "%".$value);
                        break;
                    case ($predicate == "eq" &&  in_array($type, $eq_types)):
                        $query->where($model->getTable().".".$name, "=", $value);
                        break;
                    case ($predicate == "not_eq" &&  in_array($type, $eq_types)):
                        $query->where($model->getTable().".".$name, "!=", $value);
                        break;
                    case ($predicate == "in" &&  in_array($type, $in_types)):
                        $query->whereIn($model->getTable().".".$name, $value);
                        break;
                    case ($predicate == "not_in" &&  in_array($type, $in_types)):
                        $query->whereNotIn($model->getTable().".".$name, $value);
                        break;
                    case ($predicate == "is_null" &&  in_array($type, $in_types)):
                        $query->whereNull($model->getTable().".".$name);
                        break;
                    case ($predicate == "is_not_null" &&  in_array($type, $in_types)):
                        $query->whereNotNull($model->getTable().".".$name);
                        break;
                    case ($predicate == "gt" &&  in_array($type, $gt_types)):
                        $query->where($model->getTable().".".$name, ">", $value);
                        break;
                    case ($predicate == "gteq" &&  in_array($type, $gteq_types)):
                        $query->where($model->getTable().".".$name, ">=", $value);
                        break;
                    case ($predicate == "lt" &&  in_array($type, $lt_types)):
                        $query->where($model->getTable().".".$name, "<", $value);
                        break;
                    case ($predicate == "lteq" &&  in_array($type, $lteq_types)):
                        $query->where($model->getTable().".".$name, "<=", $value);
                        break;
                    case ($predicate == "is_true" &&  in_array($type, $is_true_types)):
                        $query->where($model->getTable().".".$name, "=", true);
                        break;
                    case ($predicate == "is_false" &&  in_array($type, $is_false_types)):
                        $query->where($model->getTable().".".$name, "=", false);
                        break;
                    case ($predicate == "scp"):
                        if (method_exists($model, 'scope' . ucfirst($name))) {
                            $query->$name($value);
                        }
                        break;
                }
            }
        }

        return $query;
    }

    public static function paginateSearch($query, $params)
    {
      $options = static::parseOptions($params);

      $paginator = null;

      if (!$options["disable_pagination"])
      {
        $current_page = $options["current_page"];

        Paginator::currentPageResolver(function () use ($current_page) {
            return $current_page;
        });

        $paginator = $query->paginate($options["per_page"]);
      }

      return $paginator;
    }

    public static function parseData($request)
    {
      $data = isset($request["data"]) ? $request["data"] : [];
      return $data;
    }

    public static function parseFilter($request)
    {
      $filter = isset($request["filter"]) ? $request["filter"] : [];
      return $filter;
    }

    public static function parseQuery($request)
    {
      $filter = static::parseFilter($request);

      if (!isset($filter["q"])) {
        $filter["q"] = [];
      }

      return $filter["q"];
    }

    public static function parseOptions($request)
    {
      $filter = static::parseFilter($request);

      if (isset($filter["q"])) {
        unset($filter["q"]);
      }

      $filter["disable_pagination"] = isset($filter["disable_pagination"]) ? true : false;
      $filter["per_page"] = isset($filter["per_page"]) ? (int) $filter["per_page"] : 25;
      $filter["current_page"] = isset($filter["page"]) ? (int) $filter["page"] : 1;

      return $filter;
    }
}
