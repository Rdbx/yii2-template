<?php

namespace common\modules\acceptance\providers;

use common\modules\acceptance\AbstractAcceptanceProvider;

class CallProvider extends AbstractAcceptanceProvider
{
    public $generateAttemptMax = 5;

    public $codeAttemptMax = 5;

    public $delay = 60;

    public function getChannel()
    {
        return 'call';
    }
}
