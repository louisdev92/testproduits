<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_affiche_le_formulaire_de_creation_de_produit()
    {
        // Vérifie que le formulaire de création de produit s'affiche correctement
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertSee('Ajouter un nouveau produit');
        $response->assertSee('Nom du produit');
        $response->assertSee('Prix');
        $response->assertSee('Stock');
    }

    /** @test */
    public function test_cree_un_produit_avec_donnees_valides()
    {
        // Vérifie qu'un produit est bien créé avec des données valides
        $data = [
            'name' => 'Produit Test',
            'description' => 'Une description de test',
            'price' => 12.50,
            'stock' => 10,
        ];

        $response = $this->post(route('products.store'), $data);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Produit Test']);
    }

    /** @test */
    public function test_affiche_erreurs_validation_si_champs_obligatoires_absents()
    {
        // Vérifie que des erreurs de validation sont affichées si des champs obligatoires sont manquants
        $response = $this->post(route('products.store'), []);

        $response->assertSessionHasErrors(['name', 'price', 'stock']);
    }
}
