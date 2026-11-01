<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VariationPriceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    private function variation(): Variation
    {
        return Product::factory()->create()->variations()->create([
            'title' => 'Small Pack',
            'slug' => 'small',
            'description' => 'A small pack',
            'price' => 100,
            'is_published' => true,
        ]);
    }

    public function test_price_is_stored_in_cents_and_read_in_dollars()
    {
        $variation = $this->variation();

        $this->assertSame(10000, DB::table('variations')->where('id', $variation->id)->value('price_cents'));
        $this->assertEquals(100, $variation->fresh()->price);
    }

    public function test_staff_can_enter_a_price_with_cents()
    {
        $variation = $this->variation();

        $this->put(route('backend.variations.update', $variation), [
            'title' => 'Small Pack',
            'description' => 'A small pack',
            'price' => '19.95',
            'is_published' => 1,
        ])->assertSessionHasNoErrors();

        $this->assertSame(1995, DB::table('variations')->where('id', $variation->id)->value('price_cents'));
        $this->assertEquals(19.95, $variation->fresh()->price);
    }

    public function test_price_with_more_than_two_decimal_places_is_refused()
    {
        $variation = $this->variation();

        $this->put(route('backend.variations.update', $variation), [
            'title' => 'Small Pack',
            'description' => 'A small pack',
            'price' => '19.955',
            'is_published' => 1,
        ])->assertSessionHasErrors('price');
    }

    public function test_edit_form_shows_the_price_to_two_decimal_places()
    {
        $variation = $this->variation();

        $this->get(route('backend.variations.edit', $variation))
            ->assertOk()
            ->assertSee('value="100.00"', false);
    }

    public function test_running_the_cents_migration_again_does_not_change_prices()
    {
        $variation = $this->variation();

        $migration = require database_path('migrations/2026_11_01_000000_store_variation_prices_in_cents.php');
        $migration->up();

        $this->assertSame(10000, DB::table('variations')->where('id', $variation->id)->value('price_cents'));
    }

    public function test_a_variation_loaded_without_price_cents_throws_instead_of_reading_as_zero()
    {
        $variation = $this->variation();

        $this->expectException(\LogicException::class);

        Variation::select('id')->find($variation->id)->price;
    }

    public function test_create_form_shows_an_empty_price()
    {
        $product = Product::factory()->create();

        $this->get(route('backend.variations.create', $product))
            ->assertOk()
            ->assertSee('name="price" type="number" step="0.01" min="0" placeholder="42.00"
                        value=""', false);
    }
}
