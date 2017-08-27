<?php

namespace ChanceZeus\BranchApi\App;

use ChanceZeus\BranchApi\Types\Enum;

class AppTypeEnum extends Enum
{
    const NONE = 0;
    const STORE = 1;
    const FALLBACK = 2;
}