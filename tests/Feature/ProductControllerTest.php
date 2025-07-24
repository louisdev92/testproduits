namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
use RefreshDatabase;

public function test_affiche_liste_des_produits()
{
$response = $this->get(route('products.index'));
$response->assertStatus(200);
$response->assertViewIs('products.index');
}

public function test_cree_un_produit_valide()
{
$data = [
'name' => 'Café noir',
'price' => 15.00,
'stock' => 10
];

$response = $this->post(route('products.store'), $data);

$response->assertRedirect(route('products.index'));
$this->assertDatabaseHas('products', ['name' => 'Café noir']);
}

public function test_echec_de_validation_si_nom_est_vide()
{
$data = [
'name' => '',
'price' => 15.00,
'stock' => 10
];

$response = $this->post(route('products.store'), $data);

$response->assertSessionHasErrors('name');
}

public function test_mise_a_jour_produit()
{
$product = Product::factory()->create();
$newData = [
'name' => 'Thé noir',
'price' => 20.00,
'stock' => 25,
];

$response = $this->put(route('products.update', $product), $newData);

$response->assertRedirect(route('products.index'));
$this->assertDatabaseHas('products', ['name' => 'Thé noir']);
}

public function test_suppression_produit()
{
$product = Product::factory()->create();

$response = $this->delete(route('products.destroy', $product));

$response->assertRedirect(route('products.index'));
$this->assertDatabaseMissing('products', ['id' => $product->id]);
}

public function test_affiche_message_succes_apres_creation()
{
$data = [
'name' => 'Café crème',
'price' => 10.00,
'stock' => 30,
];

$response = $this->post(route('products.store'), $data);

$response->assertSessionHas('success');
}
}
