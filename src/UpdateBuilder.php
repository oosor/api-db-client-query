<?php
/**
 * Created by IntelliJ IDEA.
 * User: jarvis
 * Date: 20.07.19
 * Time: 12:03
 */

namespace Oosor\ClientQuery;


class UpdateBuilder extends BaseBuilder
{
    protected function getQuery(): string
    {
        return 'update';
    }

    /** set element data ['key' => 'value', ...]
     * @param array $data
     * @return $this
     * */
    public function data(array $data)
    {
        $this->data = $data;
        return $this;
    }
}