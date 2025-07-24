<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function affiche_la_page_de_liste_des_produits()
    {
        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee('Liste des Produits');
    }

    /** @test */
    public function affiche_les_produits_dans_le_tableau()
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
    public function affiche_un_message_lorsqu_aucun_produit_n_existe()
    {
        $response = $this->get(route('products.index'));

        $response->assertSee('Aucun produit trouvé');
        $response->assertSee('Ajouter un produit');
    }
}
