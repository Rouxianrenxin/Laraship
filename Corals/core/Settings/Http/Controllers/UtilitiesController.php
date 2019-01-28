<?php

namespace Corals\Settings\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class UtilitiesController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * {!! CoralsForm::select('users','Users', [], false, null,
     * ['class'=>'select2-ajax','data'=>[
     * 'model'=>\Corals\User\Models\User::class,
     * 'columns'=> json_encode(['name','email']),
     * 'selected'=>json_encode([1=>'zzzzzz',3=>'xxxxxxxxx']),
     * 'orWhere'=>json_encode([]),
     * 'where'=>json_encode([
     * ['field'=>'tableX.col_x','operation'=>'=','value'=>'xx'],
     * ['field'=>'tableX.col_y','operation'=>'=','value'=>'yy']
     * ]),
     * 'join' =>[
     * 'table'=>'tableX',
     * 'type'=>'leftJoin',
     * 'on' =>['tableX.user_id','users.id']
     * ]
     * ]],'select2')
     * !!}
     */
    public function select2(Request $request)
    {
        $this->validate($request, [
            'columns' => 'required',
            'model' => 'required'
        ]);

        $query = $request->get('query');
        $columns = $request->get('columns');
        $textColumns = $request->get('textColumns');
        $model = $request->get('model');
        $selected = $request->get('selected', []);
        $where = $request->get('where', []);
        $orWhere = $request->get('orWhere', []);
        $join = $request->get('join', []);

        $model_table = with(new $model)->getTable();


        if (empty($textColumns)) {
            $textColumns = $columns;
        }

        $result = null;

        if (empty($query) && empty($selected)) {
            return response()->json([]);
        }

        $result = $model::where(function ($q) use ($columns, $query, $model_table) {
            foreach ($columns as $index => $column) {
                $q = $q->orWhere("{$model_table}.{$column}", 'like', '%' . $query . '%');
            }
        });

        if (!empty($selected)) {
            $result = $result->whereIn($model_table . '.id', $selected);
        }

        if (!empty($where)) {
            foreach ($where as $w) {
                switch ($w['operation']) {
                    case 'in':
                        $result = $result->whereIn($w['field'], $w['value']);
                        break;
                    case 'not_in':
                        $result = $result->whereNotIn($w['field'], $w['value']);
                        break;
                    default:
                        $result = $result->where($w['field'], $w['operation'], $w['value']);
                }
            }
        }

        if (!empty($orWhere)) {
            $result = $result->where(function ($query) use ($orWhere) {
                foreach ($orWhere as $w) {
                    $query = $query->orWhere($w['field'], $w['operation'], $w['value']);
                }
            });
        }


        if (!empty($join)) {
            $result = $result->{$join['type']}($join['table'], $join['on'][0], $join['on'][1]);
        }

        $queryClass = strtolower(class_basename($model));
        $scopes = [];
        $scopes = \Filters::do_filter('select_scopes_' . $queryClass, $scopes, $queryClass);

        foreach ($scopes as $scope) {
            $scope->apply($result);
        }


        $sep = "";
        $text = "";
        foreach ($textColumns as $textColumn) {
            $text .= $sep . "{$model_table}.$textColumn";
            $sep = ',';
        }

        $id = $model_table . '.id as id';

        $result->select(\DB::raw("CONCAT_WS(' - ', $text) as text"), $id);

        $result = $result->distinct()->get();

        $results = [];

        foreach ($result as $item) {
            array_push($results, ['id' => $item->id, 'text' => $item->text]);
        }

        return response()->json($results);
    }
}
