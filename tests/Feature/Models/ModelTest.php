<?php

namespace Tests\Feature\Models;

use App\Models\Address;
use App\Models\Backgroundcolour;
use App\Models\Block;
use App\Models\Cart;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Page;
use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\Product;
use App\Models\Textcolour;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_can_persist_their_attributes(): void
    {
        $models = [
            [new Address(), ['customer_id' => 1]],
            [new Backgroundcolour(), ['background' => '#fff', 'css' => 'bg-white']],
            [new Block(), ['heading' => 'Welcome']],
            [new Cart(), []],
            [new Contact(), ['name' => 'Sam', 'email' => 'sam@example.com']],
            [new Customer(), ['name' => 'Sam', 'email' => 'sam@example.com', 'phone' => '0400000000']],
            [new Order(), ['order_status_id' => 1, 'total' => 25.50]],
            [new OrderStatus(), ['title' => 'Pending']],
            [new Page(), ['author_id' => 1, 'title' => 'About', 'slug' => 'about']],
            [new Plant(), ['title' => 'Fern', 'botanical_name' => 'Asplenium']],
            [new PlantCategory(), ['title' => 'Ferns', 'slug' => 'ferns']],
            [new Product(), ['title' => 'Plant pot', 'slug' => 'plant-pot']],
            [new Textcolour(), ['background' => '#000', 'css' => 'text-black']],
            [new Variation(), ['title' => 'Small']],
        ];

        foreach ($models as [$model, $attributes]) {
            $model->forceFill($attributes);
            $this->assertTrue($model->save(), get_class($model).' could not be saved.');
            $this->assertDatabaseHas($model->getTable(), array_merge(
                ['id' => $model->getKey()],
                $attributes
            ));
            $this->assertInstanceOf(
                get_class($model),
                $model->newQuery()->findOrFail($model->getKey())
            );
        }
    }

    public function test_user_model_persists_and_hides_authentication_secrets(): void
    {
        if (! class_exists(\TCG\Voyager\Models\User::class)) {
            $this->markTestSkipped('The TCG Voyager user model dependency is not installed.');
        }

        $user = User::factory()->create();
        $serialized = $user->toArray();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $user->email]);
        $this->assertArrayNotHasKey('password', $serialized);
        $this->assertArrayNotHasKey('remember_token', $serialized);
    }

    public function test_product_variations_and_their_inverse_relationship(): void
    {
        $product = Product::create(['title' => 'Plant pot', 'slug' => 'plant-pot']);
        $variation = Variation::create(['product_id' => $product->id, 'title' => 'Small']);

        $this->assertTrue($product->variations->contains($variation));
        $this->assertTrue($variation->product->is($product));
    }

    public function test_customer_addresses_and_orders_relationships(): void
    {
        $customer = Customer::create([
            'name' => 'Sam',
            'email' => 'sam@example.com',
            'phone' => '0400000000',
        ]);
        $address = Address::create(['customer_id' => $customer->id]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => 1,
        ]);

        $this->assertTrue($customer->address->is($address));
        $this->assertTrue($customer->orders->contains($order));
        $this->assertTrue($address->customer->is($customer));
        $this->assertTrue($order->customer->is($customer));
        $this->assertTrue($address->order->is($order));
        $this->assertTrue($order->address->is($address));
    }

    public function test_address_customer_relationship_returns_a_belongs_to_relation(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Address())->customer());
    }

    public function test_order_statuses_have_their_orders(): void
    {
        $status = (new OrderStatus())->forceFill(['title' => 'Pending']);
        $status->save();
        $order = Order::create(['order_status_id' => $status->id]);

        $this->assertTrue($status->orders->contains($order));
        $this->assertTrue($order->order_status->is($status));
    }
}
