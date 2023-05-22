<?php

namespace doc\exceptions;

class Handler extends \api\exceptions\Handler
{
    protected function renderException($ex)
    {
        parent::renderException($ex);
    }
}
