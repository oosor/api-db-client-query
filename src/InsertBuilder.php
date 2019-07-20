<?php
/**
 * Created by IntelliJ IDEA.
 * User: jarvis
 * Date: 20.07.19
 * Time: 11:54
 */

namespace Oosor\ClientQuery;


class InsertBuilder extends BaseBuilder
{
    protected function getQuery(): string
    {
        return 'insert';
    }

    /** set full data [['key' => 'value', ...], ['key' => 'value', ...]]
     * @param array $data
     * @return $this
     * */
    public function data(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /** append one element data ['key' => 'value', ...]
     * @param array $oneDatum
     * @return $this
     * */
    public function pushData(array $oneDatum)
    {
        if (empty($this->data)) {
            $this->data = [];
        }
        $this->data[] = $oneDatum;
        return $this;
    }
}