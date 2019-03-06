<?php

namespace App\Contracts;

interface FileExtractor
{
    public function categoryId(): int;
    public function products(): array;
}
