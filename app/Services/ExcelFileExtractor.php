<?php

namespace App\Services;

use Excel;
use App\Contracts\FileExtractor;
use Illuminate\Support\Facades\Storage;

class ExcelFileExtractor implements FileExtractor
{
    protected $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
    * Get category from the sheet.
    *
    * @return int
    */
    public function categoryId(): int
    {
        config(['excel.import.startRow' => 1]);

        return Excel::selectSheetsByIndex(0)
            ->load(storage_path("app/{$this->filePath}"))
            ->all()
            ->getHeading()[1];
    }

    /**
    * Get products from the sheet.
    *
    * @return array
    */
    public function products(): array
    {
        config(['excel.import.startRow' => 3]);

        return Excel::selectSheetsByIndex(0)
            ->load(storage_path("app/{$this->filePath}"))
            ->toArray();
    }
}
