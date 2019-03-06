<?php

namespace App\Jobs;

use Log;
use Exception;
use App\Product;
use App\Category;
use App\SheetFileProcess;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Contracts\FileExtractor as FileExtractorContract;

class ProcessSheetFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
    * The sheet file process model
    *
    * @var \App\SheetFileProcess
    */
    protected $sheetFileProcess;

    /**
    * The file extractor service
    *
    * @var \App\Contracts\FileExtractor
    */
    protected $fileExtractor;

    /**
    * The number of times the job may be attempted.
    *
    * @var int
    */
    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SheetFileProcess $sheetFileProcess, FileExtractorContract $fileExtractor)
    {
        $this->sheetFileProcess = $sheetFileProcess;
        $this->fileExtractor = $fileExtractor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->sheetFileProcess->setStatus('processing');

        $category = Category::firstOrCreate(['id' => $this->fileExtractor->categoryId()]);

        $product = new Product;
        foreach($this->fileExtractor->products() as $item) {
            $product->firstOrCreate(
                ['lm' => $item['lm']],
                $item + ['category_id' => $category->id]
            );
        }

        // sleep(4);

        $this->sheetFileProcess->setStatus('success');
    }

    /**
    * The job failed to process.
    *
    * @param  Exception  $exception
    * @return void
    */
    public function failed(Exception $exception)
    {
        Log::debug($exception->getMessage());

        $this->sheetFileProcess->setStatus('error');
    }
}
