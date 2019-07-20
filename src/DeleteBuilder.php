<?php
/**
 * Created by IntelliJ IDEA.
 * User: jarvis
 * Date: 20.07.19
 * Time: 12:06
 */

namespace Oosor\ClientQuery;


class DeleteBuilder extends BaseBuilder
{
    protected function getQuery(): string
    {
        return 'delete';
    }
}