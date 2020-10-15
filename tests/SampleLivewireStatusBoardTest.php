<?php

namespace Asantibanez\LivewireStatusBoard\Tests;

use Asantibanez\LivewireStatusBoard\Tests\Stubs\SampleLivewireStatusBoard;
use Livewire\LivewireManager;
use Livewire\Testing\TestableLivewire;

class SampleLivewireStatusBoardTest extends TestCase
{
    private function createComponent($parameters = []) : TestableLivewire
    {
        return app(LivewireManager::class)->test(SampleLivewireStatusBoard::class, $parameters);
    }

    /** @test */
    public function can_build_component()
    {
        //Arrange

        //Act
        $component = $this->createComponent();

        //Assert
        $this->assertNotNull($component);

        $this->assertTrue($component->viewData('statuses')->map->id->contains('todo'));
        $this->assertCount(
            1,
            $component->viewData('statuses')->where('id', 'todo')->first()['records']
        );

        $this->assertTrue($component->viewData('statuses')->map->id->contains('completed'));
        $this->assertCount(
            2,
            $component->viewData('statuses')->where('id', 'completed')->first()['records']
        );
    }

    /** @test */
    public function should_call_record_click()
    {
        //Arrange
        $component = $this->createComponent([
            'recordClickEnabled' => true,
        ]);

        $this->assertFalse($component->viewData('recordClicked'));

        //Act
        $component->runAction('onRecordClick', $component->viewData('statuses')->get(0)['records'][0]['id']);

        //Assert
        $this->assertTrue($component->viewData('recordClicked'));
    }

    /** @test */
    public function should_trigger_onStatusSorted()
    {
        //Arrange
        $component = $this->createComponent();

        $this->assertFalse($component->viewData('statusSortedCalled'));

        //Act
        $component->runAction('onStatusSorted', null, null, null);

        //Assert
        $this->assertTrue($component->viewData('statusSortedCalled'));
    }

    /** @test */
    public function should_trigger_onStatusChanged()
    {
        //Arrange
        $component = $this->createComponent();

        $this->assertFalse($component->viewData('statusChangedCalled'));

        //Act
        $component->runAction('onStatusChanged', null, null, null, null);

        //Assert
        $this->assertTrue($component->viewData('statusChangedCalled'));
    }
}
