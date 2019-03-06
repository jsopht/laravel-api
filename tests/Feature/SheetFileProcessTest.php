<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\SheetFileProcess;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SheetFileProcessTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnSheetFileProcessFieldsCorrectly()
    {
        $this->withHeaders($this->headers)
            ->json('GET', route('sheet_file_process.status'))
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'status',
                'created_at',
                'updated_at'
            ]]);
    }
}
