<?php
/**
 * Created by IntelliJ IDEA.
 * User: jarvis
 * Date: 19.07.19
 * Time: 15:11
 */

namespace Oosor\ClientQuery\Models;


class Build
{
    private $where;

    /** closure fn
     * @param array $where
     * @return void
     * */
    public function __construct(&$where)
    {
        $this->where = &$where;
    }

    /** where filter builder
     * @param \Closure|string $columnClosure
     * @param string $valueIs
     * @param mixed $value
     * @return $this
     * */
    public function where($columnClosure, $valueIs = null, $value = null)
    {
        return $this->build($columnClosure, $valueIs, $value, 'where');
    }

    /** orWhere filter builder
     * @param \Closure|string $columnClosure
     * @param string $valueIs
     * @param mixed $value
     * @return $this
     * */
    public function orWhere($columnClosure, $valueIs = null, $value = null)
    {
        return $this->build($columnClosure, $valueIs, $value, 'orWhere');
    }

    /** whereDate filter builder
     * @param string $column
     * @param string $valueIs
     * @param mixed $value
     * @return $this
     * */
    public function whereDate($column, $valueIs, $value = null)
    {
        return $this->build($column, $valueIs, $value, 'whereDate');
    }

    /** whereIn filter builder
     * @param string $column
     * @param array $value
     * @return $this
     * */
    public function whereIn($column, $value)
    {
        return $this->build($column, $value, null, 'whereIn');
    }

    /** orWhereIn filter builder
     * @param string $column
     * @param array $value
     * @return $this
     * */
    public function orWhereIn($column, $value)
    {
        return $this->build($column, $value, null, 'orWhereIn');
    }

    /** whereNull filter builder
     * @param string $column
     * @return $this
     * */
    public function whereNull($column)
    {
        $this->where[] = ['type' => 'whereNull', 'column' => $column];
        return $this;
    }

    /** whereNotNull filter builder
     * @param string $column
     * @return $this
     * */
    public function whereNotNull($column)
    {
        $this->where[] = ['type' => 'whereNotNull', 'column' => $column];
        return $this;
    }

    /** helper filter
     * @param \Closure|string $columnClosure
     * @param string $valueIs
     * @param mixed $value
     * @param string $type
     * @return $this
     * */
    protected function build($columnClosure, $valueIs = null, $value = null, $type = null)
    {
        // closure only for where and orWhere
        if (($type == 'where' || $type == 'orWhere') && $columnClosure instanceof \Closure) {
            $where = ['type' => $type, 'closure' => []];
            $build = new Build($where['closure']);
            call_user_func($columnClosure, $build);
            $this->where[] = $where;
        } else {
            if (isset($value)) {
                $this->where[] = ['type' => $type, 'column' => $columnClosure, 'is' => $valueIs, 'value' => $value];
            } else {
                $this->where[] = ['type' => $type, 'column' => $columnClosure, 'value' => $valueIs];
            }
        }
        return $this;
    }
}