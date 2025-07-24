namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
use RefreshDatabase;

public function test_un_produit_peut_etre_cree_avec_donnees_valides()
{
$product = Product::factory()->create([
'name' => 'Thé vert',
'price' => 12.50,
'stock' => 50,
]);

$this->assertDatabaseHas('products', [
'name' => 'Thé vert',
'price' => 12.50,
'stock' => 50,
]);
}

public function test_la_mise_a_jour_d_un_produit()
{
$product = Product::factory()->create();
$product->update(['price' => 19.99]);

$this->assertDatabaseHas('products', ['id' => $product->id, 'price' => 19.99]);
}

public function test_la_suppression_d_un_produit()
{
$product = Product::factory()->create();
$product->delete();

$this->assertSoftDeleted($product);
}
}
