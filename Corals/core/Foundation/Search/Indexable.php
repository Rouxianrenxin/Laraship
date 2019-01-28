<?php

namespace Corals\Foundation\Search;

use Corals\Foundation\Search\IndexedRecord;

/**
 * Class Indexable
 *
 * @package Corals\Foundation\SearchServiceProvider
 */
trait Indexable
{

    public function getIndexContent()
    {
        return $this->getIndexDataFromColumns($this->indexContentColumns);
    }

    public function getIndexTitle()
    {
        return $this->getIndexDataFromColumns($this->indexTitleColumns);
    }

    public function indexedRecord()
    {
        return $this->morphOne('Corals\Foundation\Search\IndexedRecord', 'indexable');
    }

    public function indexRecord()
    {
        if (null === $this->indexedRecord) {
            $this->indexedRecord = new IndexedRecord();
            $this->indexedRecord->indexable()->associate($this);
        }
        $this->indexedRecord->updateIndex();
    }

    public function unIndexRecord()
    {
        if (null !== $this->indexedRecord) {
            $this->indexedRecord->delete();
        }
    }

    protected function getIndexDataFromColumns($columns)
    {
        $indexData = [];
        foreach ($columns as $column) {
            if ($this->indexDataIsRelation($column)) {
                $indexData[] = $this->getIndexValueFromRelation($column);
            } else {
                $indexData[] = trim($this->{$column});
            }
        }
        return implode(' ', array_filter($indexData));
    }

    /**
     * @param $column
     * @return bool
     */
    protected function indexDataIsRelation($column)
    {
        return (int)strpos($column, '.') > 0;
    }

    /**
     * @param $column
     * @return string
     */
    protected function getIndexValueFromRelation($column)
    {
        list($relation, $column) = explode('.', $column);
        if (is_null($this->{$relation})) {
            return '';
        }
        \Logger($this->{$relation});
        return $this->{$relation}()->pluck($column)->implode(', ');
    }
}
