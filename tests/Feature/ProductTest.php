<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    protected $productJsonStructure = [
        'lm',
        'category_id',
        'name',
        'free_shipping',
        'description',
        'price',
        'updated_at',
        'created_at'
    ];

    /**
    * @test
    */
    public function productsShouldBeListedCorrectly()
    {
        $products = factory(\App\Product::class, 3)->create();

        $this->withHeaders($this->headers)
            ->json('GET', route('products.index'))
            ->assertStatus(200)
            ->assertJson(['data' => $products->toArray()])
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->productJsonStructure
                ]
            ]);
    }

    /**
    * @test
    */
    public function productShouldBeVisualizedCorrectly()
    {
        $product = factory(\App\Product::class)->create();

        $this->withHeaders($this->headers)
            ->json('GET', route('products.show', $product->lm))
            ->assertStatus(200)
            ->assertJson(['data' => $product->toArray()])
            ->assertJsonStructure(['data' => $this->productJsonStructure]);
    }

    /**
    * @test
    */
    public function productShouldBeUpdatedCorrectly()
    {
        $description = 'Leroy Merlin';

        $product = factory(\App\Product::class)->create();

        $product->description = $description;

        $this->withHeaders($this->headers)
            ->json('PUT', route('products.update', $product->lm), $product->toArray())
            ->assertStatus(200)
            ->assertJson(['data' => ['description' => $description]])
            ->assertJsonStructure(['data' => $this->productJsonStructure]);


        $this->assertDatabaseHas('products', [
            'lm' => $product->lm,
            'description' => $description
        ]);
    }

    /**
    * @test
    */
    public function productShouldBeDeletedCorrectly()
    {
        $product = factory(\App\Product::class)->create();

        $this->json('DELETE', route('products.destroy', $product->lm))
            ->assertStatus(204);

        $this->assertDatabaseMissing('products', ['lm' => $product->lm]);
    }

    /**
     * @test
     */
    public function productShoulReturnNotFound()
    {
        $product = factory(\App\Product::class)->create();

        $this->json('DELETE', route('products.destroy', $product->lm));

        $this->withHeaders($this->headers)
            ->json('GET', route('products.show', $product->lm))
            ->assertStatus(404);
    }

    /**
    * @test
    */
    public function productShoulReturnValidationErrors()
    {
        $product1 = factory(\App\Product::class)->create()->toArray();
        $product2 = factory(\App\Product::class)->create()->toArray();

        $productId = $product2['lm'];
        $product2['lm'] = $product1['lm'];

        $product2['free_shipping'] = 3;
        $product2['description'] = str_random(10001);
        $product2['name'] = 1;
        $product2['price'] = 12.002;

        $this->withHeaders($this->headers)
            ->json('PUT', route('products.update', $productId), $product2)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'lm' => [
                        'The lm has already been taken.'
                    ],
                    'name' => [
                        'The name must be a string.'
                    ],
                    'free_shipping' => [
                        'The free shipping field must be true or false.'
                    ],
                    'description' => [
                        'The description may not be greater than 1000 characters.'
                    ],
                    'price' => [
                        'The price format is invalid.'
                    ]
                ]
            ]);
    }


    /**
    * @test
    */
    public function spreadsheetStoreShouldReturnFileError()
    {
        $file = UploadedFile::fake()->create('document.csv');

        $this->withHeaders($this->headers)
            ->json('POST', route('products.store'), ['spreadsheet' => $file])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'spreadsheet' => [
                        'The spreadsheet must be a file of type: xlsx.'
                    ]
                ]
            ]);
    }

    /**
    * @test
    */
    public function spreadsheetStoreShouldReturnErrorFileRequired()
    {
        $this->withHeaders($this->headers)
            ->json('POST', route('products.store'))
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'spreadsheet' => [
                        'The spreadsheet field is required.'
                    ]
                ]
            ]);
    }
}
