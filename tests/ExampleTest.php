<?php

namespace Asantibanez\LivewireStatusBoard\Tests;

use Orchestra\Testbench\TestCase;
use Asantibanez\LivewireStatusBoard\LivewireStatusBoardServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LivewireStatusBoardServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
