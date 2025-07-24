<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductShowAndDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_product_details()
    {
        $product = Product::factory()->create([
            'name' => 'Produit à Voir',
            'description' => 'Description du produit',
            'price' => 99.99,
            'stock' => 15,
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee('Détails du produit');
        $response->assertSee('Produit à Voir');
        $response->assertSee('Description du produit');
        $response->assertSee('99,99 €');
        $response->assertSee('15');
    }

    /** @test */
    public function it_deletes_a_product_successfully()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
