<?php

namespace Corals\Foundation\DataTables;


use Yajra\DataTables\Contracts\DataTableScope;

class CoralsScope implements DataTableScope
{
    public $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function apply($query)
    {
        $requestFilters = urldecode(request()->filters);

        $filters = $this->filters;

        if (!$requestFilters || empty($filters)) {
            return $query;
        }

        $requestFilters = $this->getRequestFiltersArray($requestFilters);

        foreach ($requestFilters as $column => $value) {

            if (isset($filters[$column]) && !empty($value)) {

                $filter = $filters[$column];

                $condition = $filter['condition'] ?? '=';

                $relation = null;

                if (stripos($column, '.') != false) {
                    list($relation, $column) = explode('.', $column);
                } else {
                    $model = $query->getModel();
                    $model_table = with(new $model)->getTable();
                    $column = $model_table . "." . $column;
                }


                switch ($filter['type']) {
                    case 'date':
                        $function = $this->functionMap('date');
                        break;
                    case 'date_range':
                        $function = $this->functionMap('date_range');
                        if (is_array($value) && count($value) == 1) {
                            if (isset($value['from'])) {
                                $function = 'whereDate';
                                $value = $value['from'];
                                $condition = '>=';
                            } elseif (isset($value['to'])) {
                                $function = 'whereDate';
                                $value = $value['to'];
                                $condition = '<=';
                            } else {
                                $function = 'where';
                                $value = current($value);
                            }
                        }
                        break;
                    default:
                        $function = isset($filter['function']) ? $this->functionMap($filter['function']) : 'where';
                }

                switch ($condition) {
                    case 'like':
                        if ($relation) {
                            $query = $query->whereHas($relation, function ($relQuery) use ($function, $column, $value) {
                                return $relQuery->{$function}($column, 'like', "%$value%");
                            });
                        } else {
                            $query = $query->{$function}($column, 'like', "%$value%");
                        }
                        break;
                    case  '=':
                        if ($relation) {
                            $query = $query->whereHas($relation, function ($relQuery) use ($function, $column, $value) {
                                return $relQuery->{$function}($column, $value);
                            });
                        } else {
                            $query = $query->{$function}($column, $value);
                        }
                        break;
                    default:
                        if ($relation) {
                            $query = $query->whereHas($relation, function ($relQuery) use ($function, $condition, $column, $value) {
                                return $relQuery->{$function}($column, $condition, $value);
                            });
                        } else {
                            $query = $query->{$function}($column, $condition, $value);
                        }
                }
            }
        }

        return $query;
    }

    private function getRequestFiltersArray($requestFilters)
    {
        $array = explode("&", $requestFilters);

        if (!(count($array) == 1 && $array[0] == "")) {
            foreach ($array as $key => $value) {
                $filter = explode("=", $value);
                preg_match_all('/(.*)\[(.*?)\]/', $filter[0], $matches);
                if (is_array($matches[0]) && (count($matches[0]) > 0)) {
                    if ($filter[1]) {
                        $array[$matches[1][0]][trim($matches[2][0], "'")] = $filter[1];
                    }

                } else {
                    $array[$filter[0]] = $filter[1];

                }
                unset ($array[$key]);
            }
            return $array;
        } else {
            return [];
        }
    }

    private function functionMap($function = '')
    {
        $functionMap = [
            'between' => 'whereBetween',
            'not between' => 'whereNotBetween',
            'in' => 'whereIn',
            'not in' => 'whereNotIn',
            'null' => 'whereNull',
            'not null' => 'whereNotNull',
            'date' => 'whereDate',
            'date_range' => 'whereBetween',
        ];

        $function = $functionMap[$function] ?? 'where';
        return $function;
    }
}