<?php

namespace ChanceZeus\BranchApi\Tests;

use ChanceZeus\BranchApi\BranchApiServiceProvider;
use ChanceZeus\BranchApi\Facades\BranchApi;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [BranchApiServiceProvider::class];
    }

    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'BranchApi' => BranchApi::class,
        ];
    }
}
