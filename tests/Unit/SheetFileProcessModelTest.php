<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\SheetFileProcess;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SheetFileProcessModelTest extends TestCase
{
    /**
     * @test
     */
    public function processStatusShouldBeGetCorrectly()
    {
        $sheetFileProcess = SheetFileProcess::first();

        $status = 'success';
        $sheetFileProcess->setStatus($status);
        $this->assertEquals($status, $sheetFileProcess->getStatus());
    }
}
