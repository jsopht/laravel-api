<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\SheetFileProcess;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\ProcessSheetFile as ProcessSheetFileJob;


class ExcelFileExtractorTest extends TestCase
{
    /**
    * @test
    */
    public function excelFileShouldBeProcessedCorrectly()
    {
        $categoryId = 123;
        $products = factory(\App\Product::class, 3)->make([
            'category_id' => $categoryId
        ])->toArray();

        $fileExtractor = Mockery::mock(\App\Services\ExcelFileExtractor::class);
        $fileExtractor->allows(['categoryId' => $categoryId]);
        $fileExtractor->allows(['products' => $products]);

        $processSheetFileJob = new ProcessSheetFileJob(
            SheetFileProcess::first(),
            $fileExtractor
        );

        $processSheetFileJob->handle();

        $this->assertDatabaseHas('categories', ['id' => $categoryId])
            ->assertDatabaseHas('products', $products[0]);
    }
}
