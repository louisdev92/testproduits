<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_product_list_page()
    {
        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee('Liste des Produits');
    }

    /** @test */
    public function it_displays_products_in_the_table()
    {
        $product = Product::factory()->create([
            'name' => 'Produit Test',
            'description' => 'Description test',
            'price' => 19.99,
            'stock' => 5,
        ]);

        $response = $this->get(route('products.index'));

        $response->assertSee('Produit Test');
        $response->assertSee('Description test');
        $response->assertSee('19,99 €');
        $response->assertSee('5');
    }

    /** @test */
    public function it_shows_a_message_when_no_products_exist()
    {
        $response = $this->get(route('products.index'));

        $response->assertSee('Aucun produit trouvé');
        $response->assertSee('Ajouter un produit');
    }
}
