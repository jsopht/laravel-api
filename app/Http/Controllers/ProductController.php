<?php

namespace App\Http\Controllers;

use App\Product;
use App\SheetFileProcess;
use Illuminate\Http\Request;
use App\Jobs\ProcessSheetFile;
use Illuminate\Validation\Rule;
use App\Services\ExcelFileExtractor;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return ProductResource::collection(Product::paginate());
    }

    /**
    * Store a newly created resources in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store(Request $request)
    {
        $request->validate(['spreadsheet' => 'required|file|mimes:xlsx']);

        $sheetPath = $request->file('spreadsheet')->store('sheets');
        $excelFileExtractor = new ExcelFileExtractor($sheetPath);

        $sheetFileProcess = SheetFileProcess::first();
        $sheetFileProcess->setStatus('processing');

        ProcessSheetFile::dispatch($sheetFileProcess, $excelFileExtractor);

        $body = ['message' => 'The spreadsheet has been added to the process queue.'];

        return response()->json(['data' => $body], 202);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Product  $product
    * @return \Illuminate\Http\Response
    */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Product  $product
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'lm' => [
                'sometimes',
                'integer',
                'min:1',
                Rule::unique('products')->ignore($product->lm, 'lm')
            ],
            'name' => 'sometimes|string|max:255',
            'free_shipping' => 'sometimes|boolean',
            'description' => 'sometimes|string|max:1000',
            'price' => 'sometimes|regex:/^\d*(\.\d{1,2})?$/'
        ]);

        $product->update($data);

        return new ProductResource($product);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Product  $product
    * @return \Illuminate\Http\Response
    */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
