<?php

namespace Corals\Foundation\Traits;


trait ModelHelpersTrait
{
    public function getShowURL($id = null, $params = [])
    {
        if (is_null($id)) {
            $id = $this->hashed_id;
        } else {
            $id = hashids_encode($id);
        }

        $config = config($this->config);

        if ($config) {
            return urlWithParameters($config['resource_url'] . '/' . $id, $params);
        } else {
            return null;
        }
    }

    public function getEditUrl($resource_url = null, $id = null, $params = [])
    {
        if (is_null($id)) {
            $id = $this->hashed_id;
        } else {
            $id = hashids_encode($id);
        }
        if (!$resource_url) {
            $config = config($this->config);
            $resource_url = $config['resource_url'];
        }

        return urlWithParameters($resource_url . '/' . $id . '/edit', $params);


    }

    public static function getCreateUrl($params = [])
    {

        $obj = new static();

        $config = config($obj->config);

        if ($config) {
            return urlWithParameters($config['resource_url'] . '/create', $params);
        } else {
            return null;
        }
    }

    public function getIdentifier($key = null)
    {
        $identifier = '-';

        if (!is_null($key)) {
            $identifier = $this->attributes[$key] ?? '-';
        } elseif (array_has($this->attributes, 'name')) {
            $identifier = $this->name;
        } elseif (array_has($this->attributes, 'title')) {
            $identifier = $this->title;
        } elseif (array_has($this->attributes, 'caption')) {
            $identifier = $this->caption;
        }

        return $identifier;
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function getConfig($key)
    {
        return config($this->config . '.' . $key);
    }

}