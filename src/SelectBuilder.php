<?php
/**
 * Created by IntelliJ IDEA.
 * User: jarvis
 * Date: 19.07.19
 * Time: 15:31
 */

namespace Oosor\ClientQuery;


use Oosor\ClientQuery\Models\Build;

class SelectBuilder extends BaseBuilder
{
    protected function getQuery(): string
    {
        return 'select';
    }

    /** add (update) select columns
     * @param string[] $columns
     * @return $this
     * */
    public function columns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param string $column
     * @return $this
     * */
    public function addColumn(string $column)
    {
        if (isset($this->columns) && is_array($this->columns)) {
            $this->columns[] = $column;
        } else {
            $this->columns = [$column];
        }
        return $this;
    }

    /** order by $direction
     * @param string $column
     * @param !string $direction
     * @return $this
     * */
    public function order(string $column, $direction = null)
    {
        $this->order = isset($direction) ? [$column, $direction] : [$column];
        return $this;
    }

    /** order by ASC
     * @param string $column
     * @return $this
     * */
    public function orderAsc(string $column)
    {
        return $this->order($column);
    }

    /** order by DESC
     * @param string $column
     * @return $this
     * */
    public function orderDesc(string $column)
    {
        return $this->order($column, 'DESC');
    }

    /**
     * @param int $skipSelect
     * @param !int $select
     * @return $this
     * */
    public function limit(int $skipSelect, $select = null)
    {
        $this->limit = isset($select) ? [$skipSelect, $select] : [$skipSelect];
        return $this;
    }

    /** with closure (support only type leftJoin)
     * @param string $table
     * @param string $foreignKey
     * @param string $otherKey
     * @param \Closure $closure
     * @param string $type
     * @return $this
     * */
    public function with(string $table, string $foreignKey, string $otherKey, $closure = null, $type = null)
    {
        if (is_null($type)) {
            $type = 'leftJoin';
        }
        $with = ['type' => $type, 'table' => $table, 'foreign_key' => $foreignKey, 'other_key' => $otherKey];

        if (isset($closure) && $closure instanceof \Closure) {
            $with['closure'] = [];
            $build = new Build($with['closure']);
            call_user_func($closure, $build);
        }

        $this->with[] = $with;

        return $this;
    }

}