<?php
if (!function_exists('is_demo_mode')) {
    /**
     * @return mixed
     */
    function is_demo_mode()
    {
        return config('app.demo_mode');
    }
}

if (!function_exists('throw_demo_exception')) {
    /**
     * @throws Exception
     */
    function throw_demo_exception()
    {
        throw new \Exception('you can only update / delete your data in demo mode');
    }
}

if (!function_exists('hashids_encode')) {
    /**
     * Encode the given id.
     * @param $id
     * @return mixed
     */
    function hashids_encode($id)
    {
        return \Corals\Foundation\Facades\Hashids::encode($id);
    }

}

if (!function_exists('hashids_decode')) {
    /**
     * Decode the given value.
     * @param $value
     * @return null
     */
    function hashids_decode($value)
    {
        $decoded_value = \Corals\Foundation\Facades\Hashids::decode($value);

        if (empty($decoded_value)) {
            return null;
        }

        if (count($decoded_value) == 1) {
            return $decoded_value[0];
        }

        return $decoded_value;
    }
}

if (!function_exists('removeEmptyArrayElement')) {
    function removeEmptyArrayElement($attribute)
    {
        // check for empty strings and null values
        // 0 excluded for cases such as min=0 in input attributes

        if ($attribute === 0 || $attribute === false) {
            return true;
        }

        return !empty($attribute);
    }
}

if (!function_exists('format_date')) {
    /**
     * @param $date
     * @param string $format
     * @return false|null|string
     */
    function format_date($date, $format = 'd M, Y')
    {
        if (empty($date)) {
            return null;
        }

        return date($format, strtotime($date));
    }

}

if (!function_exists('format_date_time')) {
    /**
     * @param $datetime
     * @param string $format
     * @return false|string
     */
    function format_date_time($datetime, $format = 'd M, Y h:i A')
    {
        if (empty($datetime)) {
            return null;
        }

        return date($format, strtotime($datetime));
    }

}

if (!function_exists('format_time')) {
    /**
     * @param $time
     * @param string $format
     * @return false|string
     */
    function format_time($time, $format = 'h:i A')
    {
        return date($format, strtotime($time));
    }
}

if (!function_exists('log_exception')) {
    function log_exception(\Exception $exception = null, $object = null, $action = null, $message = null, $echo_message = false)
    {
        logger(array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2), -1));

        if ($exception) {
            report($exception);
            $message = $exception->getMessage() . '. ' . ($message ?? '');
        }

        $activity = activity()
            ->inLog('exception')
            ->withProperties(['attributes' => ['action' => $action, 'object' => $object, 'message' => $message]]);

        if (user()) {
            $activity = $activity->causedBy(user());
        }

        $activity = $activity->log(str_limit($message, 180));

        if (request()->ajax()) {
            $message = ['level' => 'error', 'message' => $message];
            request()->session()->flash('notification', $message);
            if ($echo_message) {

                $return_message = ['notification' => $message];
                echo json_encode($return_message);
                die();

            } else {
                if (request()->wantsJson()) {
                    if ($echo_message) {
                        $return_message = ['notification' => $message];
                        echo response()->json($return_message);
                    }

                } else {
                    $return_message = ['notification' => $message];
                    echo json_encode($return_message);
                    die();
                }
            }

        } else {
            flash($message, 'error');
        }

    }
}

if (!function_exists('generatePopover')) {
    function generatePopover($content, $text = '', $icon = 'fa fa-sticky-note', $placement = 'bottom', $trigger = null)
    {
        if (empty($content)) {
            return '-';
        }

        $content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
//        $content = addslashes($content);
        $content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');

        return '<a href="#" onclick="event.preventDefault();" data-toggle="popover" data-placement="' . $placement . '" data-html="true" ' . (!is_null($trigger) ? ('data-trigger="' . $trigger . '"') : '') . '" data-content="' . $content . '"><i class="' . $icon . '"></i> ' . $text . '</a>';
    }
}

if (!function_exists('formatStatusAsLabels')) {
    function formatStatusAsLabels($status, $customConfig = [])
    {
        $is_active = $status == 'active' || $status === 1 || $status === true;

        $is_inactive = $status == 'inactive' || $status === 0 || $status === false;

        $is_pending = $status == 'pending' || $status === 0 || $status === false;

        $default_translation_key = (is_numeric($status) || is_bool($status)) ? 'Corals::attributes.status_options_boolean.' : 'Corals::attributes.status_options.';

        $defaultLevel = $is_active ? 'success' : ($is_inactive ? 'warning' : ($is_pending ? 'info' : 'default'));

        $level = array_get($customConfig, 'level', $defaultLevel);

        $icon = array_get($customConfig, 'icon', '');

        $defaultText = trans($default_translation_key . ($status ?: 0));

        $text = array_get($customConfig, 'text', $defaultText);

        $response = "<span class=\"badge label label-{$level} badge-{$level} \">{$icon} {$text}</span>";

        return $response;
    }
}
if (!function_exists('formatArrayAsLabels')) {
    function formatArrayAsLabels($array, $level = 'default', $icon = '', $show_key = false)
    {
        $response = '';

        if (!$array) {
            return '';
        }

        foreach ($array as $key => $item) {
            if ($show_key) {
                $response .= "<span class=\"label label-{$level} badge badge-{$level} m-r-5 mr-1 \">{$icon} {$key} : <b> {$item} </b></span>";
            } else {
                $response .= "<span class=\"label label-{$level} badge badge-{$level} m-r-5 mr-1 \">{$icon} {$item}</span>";
            }
        }

        if (empty($response)) {
            return '-';
        }

        return $response;
    }
}

if (!function_exists('getGatewayStatus')) {
    function getGatewayStatus($item)
    {
        return $item->gateway_status ? ($item->gateway_status == 'failed' ? generatePopover($item->gateway_message, ucfirst($item->gateway_status), 'fa fa-times-circle-o text-danger') : '<i class="fa fa-check-circle-o text-success"></i> ' . ucfirst($item->gateway_status)) : 'NA';
    }
}

if (!function_exists('maxUploadFileSize')) {
    function maxUploadFileSize($unit = 'KB')
    {
        $size = config('medialibrary.max_file_size');

        switch ($unit) {
            case 'B':
                break;
            case 'KB':
                $size = $size / 1024;
                break;
            case 'MB':
                $size = $size / (1024 * 1024);
                break;
        }

        return $size;
    }
}

if (!function_exists('redirectTo')) {
    /**
     * @param null $to
     * @param int $status
     * @param array $headers
     * @param null $secure
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     */
    function redirectTo($to = null, $status = 302, $headers = [], $secure = null)
    {
        $request = request();
        if ($request->wantsJson()) {

            $result = ['status' => 'success', 'action' => 'redirectTo', 'url' => url($to)];

            if ($request->has('translation_submit')) {
                unset($result['action']);
            }

            if ($request->session()->has('notification')) {
                $result['notification'] = $request->session()->pull('notification');
            }

            return response()->json($result);
        }
        if (is_null($to)) {
            return app('redirect');
        }

        return app('redirect')->to($to, $status, $headers, $secure);
    }
}

if (!function_exists('getKeyValuePairs')) {
    /**
     * @param $pairs
     * @return array
     */
    function getKeyValuePairs($pairs)
    {
        if (empty($pairs)) {
            return [];
        }

        if (!is_array($pairs)) {
            $pairs = json_decode($pairs, true) ?? [];
        }

        $response = [];
        foreach ($pairs as $pair) {
            $response[current($pair)] = next($pair);
        }

        return $response;
    }
}

if (!function_exists('getQueryWithParameters')) {
    function getQueryWithParameters($query)
    {
        $sql = $query->toSql();
        $parameters = $query->getBindings();
        $result = "";

        $sql_chunks = explode('?', $sql);
        foreach ($sql_chunks as $key => $sql_chunk) {
            if (isset($parameters[$key])) {
                $result .= $sql_chunk . '"' . $parameters[$key] . '"';
            }
        }

        return $result;
    }
}

if (!function_exists('generateCopyToClipBoard')) {
    function generateCopyToClipBoard($key, $text)
    {
        return '<b id="shortcode_' . $key . '">' . $text . '</b> 
                <a href="#" onclick="event.preventDefault();" class="copy-button"
                data-clipboard-target="#shortcode_' . $key . '"><i class="fa fa-clipboard"></i></a>';
    }
}

if (!function_exists('schemaHasTable')) {
    function schemaHasTable($table)
    {
        return \Cache::remember('schema_has_' . $table, 1440, function () use ($table) {
            try {
                return \Schema::hasTable($table);
            } catch (\Exception $exception) {
                return false;

            }
        });
    }
}

if (!function_exists('getColsInRows')) {
    function getColsInRows($fieldClass)
    {
        switch ($fieldClass) {
            case 'col-md-1':
                $fieldsInRow = 12;
                break;
            case 'col-md-2':
                $fieldsInRow = 6;
                break;
            case 'col-md-3':
                $fieldsInRow = 4;
                break;
            case 'col-md-4':
                $fieldsInRow = 3;
                break;
            case 'col-md-5':
            case 'col-md-6':
                $fieldsInRow = 2;
                break;
            case 'col-md-7':
            case 'col-md-8':
            case 'col-md-9':
            case 'col-md-10':
            case 'col-md-11':
            case 'col-md-12':
                $fieldsInRow = 1;
                break;
            default:
                $fieldsInRow = 3;
        }

        return $fieldsInRow;
    }
}

if (!function_exists('renderContentInBSRows')) {
    function renderContentInBSRows($content, $colClass = 'col-md-12')
    {
        $j = 0;

        $colsInRow = getColsInRows($colClass);

        $output = '';

        if (!is_array($content)) {
            $content = [$content];
        }

        foreach ($content as $columnContent) {
            if ($j == 0) {
                $output .= '<div class="row">';
            }

            $output .= '<div class="' . $colClass . '">';

            $output .= $columnContent;

            $output .= '</div>';

            if (++$j == $colsInRow) {
                $output .= '</div>';
                $j = 0;
            }
        }

        if ($j > 0) {
            $output .= '</div>';
        }

        return $output;
    }
}

if (!function_exists('get_key_translation')) {
    function get_key_translation($key)
    {
        return trans($key);
    }
}

if (!function_exists('get_array_key_translation')) {
    function get_array_key_translation($array)
    {
        return array_map('get_key_translation', $array);
    }
}

if (!function_exists('cleanJSONFileContent')) {
    function cleanJSONFileContent($content)
    {
        // remove comments
        $content = preg_replace('!/\*.*?\*/!s', '', $content);

        // remove empty lines that can create errors
        $content = preg_replace('/\n\s*\n/', "\n", $content);

        return $content;
    }
}

if (!function_exists('urlWithParameters')) {
    function urlWithParameters($urlString, $params = [])
    {
        $url = url($urlString);
        if (!empty($params)) {
            $url = $url . '?' . http_build_query($params);
        }
        return $url;
    }
}

if (!function_exists('getObjectClassForViews')) {
    function getObjectClassForViews($object)
    {
        return str_replace('\\', '\\\\', get_class($object));
    }
}


if (!function_exists('checkActiveKey')) {

    function checkActiveKey($value, $compareWithKey)
    {

        if (request()->has($compareWithKey)) {

            $compareWithKey = request()->get($compareWithKey);

            if (is_array($compareWithKey)) {

                return array_search($value, $compareWithKey) !== false;
            } else {
                return $value == $compareWithKey;
            }
        }
    }
}
if (!function_exists('HtmlElement')) {
    function HtmlElement(string $tag, $attributes = null, $content = null): string
    {
        return \Spatie\HtmlElement\HtmlElement::render(...func_get_args());
    }
}

if (!function_exists('getUserByHash')) {
    function getUserByHash($user_hashed_id)
    {
        $user = Corals\User\Models\User::findByHash($user_hashed_id);
        return $user;
    }
}

if (!function_exists('isJoined')) {

    function isJoined($query, $table)
    {

        $joins = null;

        if ($query instanceof Illuminate\Database\Eloquent\Builder) {
            $joins = $query->getQuery()->joins;
        } else if ($query instanceof Illuminate\Database\Query\Builder) {
            $joins = $query->joins;

        }
        if ($joins == null) {
            return false;
        }
        foreach ($joins as $join) {
            if ($join->table == $table) {
                return true;
            }
        }
        return false;
    }

}