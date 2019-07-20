<?php
/**
 * Created by IntelliJ IDEA.
 * User: jarvis
 * Date: 19.07.19
 * Time: 15:10
 */

namespace Oosor\ClientQuery;


use Oosor\ClientQuery\Models\Build;

/**
 * // where methods
 * @method $this where($columnClosure, $valueIs = null, $value = null)
 * @method $this orWhere($columnClosure, $valueIs = null, $value = null)
 * @method $this whereDate($column, $valueIs, $value = null)
 * @method $this whereIn($columnClosure, $value)
 * @method $this orWhereIn($columnClosure, $value)
 * @method $this whereNull($column)
 * @method $this whereNotNull($column)
 * */
abstract class BaseBuilder
{
    protected $table;
    protected $columns;
    protected $order;
    protected $limit;
    protected $where;
    protected $with;
    protected $data;

    /** base builder requesting api-db
     * @param string $table
     * @return void
     * */
    public function __construct($table)
    {
        $this->table = $table;
    }

    /** type query
     * @return string
     * */
    protected abstract function getQuery(): string;

    /** set (update) table name
     * @param string $name
     * @return $this
     * */
    public function table(string $name)
    {
        $this->table = $name;
        return $this;
    }

    /** magic where closure
     * @param string $name
     * @param mixed $arguments
     * @return $this
     * */
    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'where':
            case 'orWhere':
            case 'whereDate':
            case 'whereIn':
            case 'orWhereIn':
            case 'whereNull':
            case 'whereNotNull':
                $this->callWhere($name, $arguments);
        }

        return $this;
    }

    /** helper where closure
     * @param string $method
     * @param mixed $params
     * */
    protected function callWhere($method, $params)
    {
        $build = new Build($this->where);
        $build->{$method}(...$params);
    }

    /** get result for requesting data
     * @return array
     * */
    public function getResult()
    {
        $data = [
            'query' => $this->getQuery(),
            'table' => $this->table,
        ];

        if (isset($this->columns)) {
            $data['columns'] = $this->columns;
        }
        if (isset($this->with)) {
            $data['with'] = $this->with;
        }
        if (isset($this->where)) {
            $data['where'] = $this->where;
        }
        if (isset($this->data)) {
            $data['data'] = $this->data;
        }
        if (isset($this->order)) {
            $data['order'] = $this->order;
        }
        if (isset($this->limit)) {
            $data['limit'] = $this->limit;
        }

        return $data;
    }
}