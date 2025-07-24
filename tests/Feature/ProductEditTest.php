<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_edit_form_with_existing_product_data()
    {
        $product = Product::factory()->create([
            'name' => 'Produit Original',
            'description' => 'Description originale',
            'price' => 15.00,
            'stock' => 20,
        ]);

        $response = $this->get(route('products.edit', $product));

        $response->assertStatus(200);
        $response->assertSee('Modifier le produit');
        $response->assertSee('Produit Original');
        $response->assertSee('Description originale');
    }

    /** @test */
    public function it_updates_the_product_with_valid_data()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Produit Modifié',
            'description' => 'Nouvelle description',
            'price' => 25.99,
            'stock' => 5,
        ];

        $response = $this->put(route('products.update', $product), $updatedData);

        $response->assertRedirect(route('products.show', $product));
        $this->assertDatabaseHas('products', ['name' => 'Produit Modifié']);
    }

    /** @test */
    public function it_shows_validation_errors_when_updating_with_invalid_data()
    {
        $product = Product::factory()->create();

        $response = $this->put(route('products.update', $product), [
            'name' => '',
            'price' => '',
            'stock' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'price', 'stock']);
    }
}
