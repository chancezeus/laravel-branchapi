<?php

namespace ChanceZeus\BranchApi\Facades;

use Illuminate\Support\Facades\Facade;

class BranchApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'branch-api';
    }
}
