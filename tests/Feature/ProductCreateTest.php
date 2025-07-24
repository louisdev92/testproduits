<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_create_product_form()
    {
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertSee('Ajouter un nouveau produit');
        $response->assertSee('Nom du produit');
        $response->assertSee('Prix');
        $response->assertSee('Stock');
    }

    /** @test */
    public function it_creates_a_product_with_valid_data()
    {
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
    public function it_shows_validation_errors_for_missing_required_fields()
    {
        $response = $this->post(route('products.store'), []);

        $response->assertSessionHasErrors(['name', 'price', 'stock']);
    }
}
