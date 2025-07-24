<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function affiche_le_formulaire_de_modification_avec_les_données_du_produit()
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
    public function met_à_jour_le_produit_avec_des_données_valides()
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
    public function affiche_des_erreurs_de_validation_lors_de_la_mise_à_jour_avec_des_données_invalides()
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
