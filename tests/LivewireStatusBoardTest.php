<?php

namespace Asantibanez\LivewireStatusBoard\Tests;

use Asantibanez\LivewireStatusBoard\LivewireStatusBoard;
use Livewire\LivewireManager;
use Livewire\Testing\TestableLivewire;

class LivewireStatusBoardTest extends TestCase
{
    private function createComponent($parameters) : TestableLivewire
    {
        return app(LivewireManager::class)->test(LivewireStatusBoard::class, $parameters);
    }

    /** @test */
    public function can_build_component()
    {
        //Arrange

        //Act
        $component = $this->createComponent([]);

        //Assert
        $this->assertNotNull($component);
    }
}
