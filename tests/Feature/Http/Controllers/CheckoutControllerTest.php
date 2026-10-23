<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Mail\OrderInvoiceMail;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createCheckoutPage($stock = false)
    {
        Page::factory()->create([
            'title' => 'Checkout',
            'slug' => 'checkout',
        ]);

        Page::factory()->create([
            'title' => 'Cart',
            'slug' => 'cart',
        ]);

        // create products
        $product = Product::factory()->create([
            'title' => 'Product 1',
            'slug' => 'product-1',
            'code' => 'PROD1',
            'image' => 'https://via.placeholder.com/150',
            'description' => 'This is a test product',
            'published' => true,
            'stocked' => $stock,
        ]);

        if ($stock === true) {
            // create variations
            $data = [
                [

                    'title' => 'Small Pack',
                    'slug' => 'small',
                    'image' => 'https://via.placeholder.com/150',
                    'description' => 'This is a small product',
                    'price' => 100,
                    'is_published' => true,
                ],
                [

                    'title' => 'Medium Pack',
                    'slug' => 'medium',
                    'image' => 'https://via.placeholder.com/150',
                    'description' => 'This is a medium product',
                    'price' => 200,
                    'is_published' => true,
                ],
                [

                    'title' => 'Large Pack',
                    'slug' => 'large',
                    'image' => 'https://via.placeholder.com/150',
                    'description' => 'This is a large product',
                    'price' => 300,
                    'is_published' => true,
                ],
            ];


            $product->variations()->createMany($data);
        }
    }

    private function correctlyFillCart()
    {
        return $this->post('/cart', [
            'id' => Variation::where('slug', 'small')->value('id'),
        ]);
    }

    private function addVariationToCart($price)
    {
        $variation = Product::first()->variations()->create([
            'title' => 'Custom Pack',
            'slug' => 'custom',
            'image' => 'https://via.placeholder.com/150',
            'description' => 'A pack at a set price',
            'price' => $price,
            'is_published' => true,
        ]);

        return $this->post('/cart', ['id' => $variation->id]);
    }

    private function correctlyFillCheckoutForm()
    {
        return $this->post('/checkout', [
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'phone' => '0491 570 000',
        ]);
    }

    private function correctlyFillDeliveryForm()
    {
        return $this->post('/checkout/delivery', [
            'line1' => '123 Test Street',
            'city' => 'Testville',
            'postcode' => '3000',
            'state' => 'VIC',
            'country' => 'Australia',
        ]);
    }

    private function correctlyFillPaymentForm()
    {
        // return $this->post('/checkout/card', [
        //     'name' => 'John Doe',
        //     'number' => '4242424242424242',
        //     'expiry_month' => '12',
        //     'expiry_year' => '2026',
        //     'cvc' => '123',
        // ]);

        // fake the payment gateway
        Http::fake();

        return Http::post('/checkout/card', [
            'name' => 'John Doe',
            'number' => '4242424242424242',
            'expiry_month' => '12',
            'expiry_year' => '2026',
            'cvc' => '123',
        ]);
    }

    public function test_empty_cart_should_return_a_200_status_code()
    {
        $this->createCheckoutPage();
        $response = $this->get('/checkout');
        $response->assertSee('Checkout');
        $response->assertSee('Cart empty');
        $response->assertStatus(200);
    }

    public function test_cart_with_stocked_product_should_show_a_form()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $response = $this->get('/checkout');
        $response->assertSee('Contact Details');

        // assert form fields
        $response->assertSee('Name');
        $response->assertSee('Email');
        $response->assertSee('Phone');
    }

    public function test_checkout_form_should_be_validated()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $response = $this->post('/checkout', [
            'name' => '',
            'email' => '',
            'phone' => '',
        ]);

        $response->assertSessionHasErrors('name');
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors('phone');
    }

    public function test_checkout_form_should_be_validated_with_correct_error_messages()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $response = $this->post('/checkout', [
            'name' => '',
            'email' => '',
            'phone' => '',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'The name field can not be blank.',
            'email' => 'The email field can not be blank.',
            'phone' => 'The phone field can not be blank.',
        ]);
    }

    public function test_checkout_correctly_filled_out_form_directs_to_delivery_form()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $response = $this->correctlyFillCheckoutForm();

        $response->assertRedirect('/checkout/delivery');
    }

    public function test_order_records_the_gst_included_in_the_total()
    {
        $this->createCheckoutPage(true);
        $this->addVariationToCart(110);

        $this->correctlyFillCheckoutForm();

        $order = Order::first();
        $this->assertEquals(110.00, $order->total);
        $this->assertEquals(10.00, $order->gst);
    }

    public function test_order_total_of_a_thousand_dollars_or_more_is_saved()
    {
        $this->createCheckoutPage(true);
        $this->addVariationToCart(1234.50);

        $this->correctlyFillCheckoutForm()->assertRedirect('/checkout/delivery');

        $order = Order::first();
        $this->assertEquals(1234.50, $order->total);
        $this->assertEquals(112.23, $order->gst);
    }

    public function test_cart_order_and_invoice_show_the_same_gst()
    {
        $this->createCheckoutPage(true);
        $this->addVariationToCart(229);

        $this->get('/cart')->assertSeeInOrder(['Includes GST', '$20.82']);

        $this->correctlyFillCheckoutForm();
        $order = Order::first();
        $this->assertEquals(20.82, $order->gst);
        $this->assertSame(20.82, $order->gstAmount());

        (new OrderInvoiceMail($order))->assertSeeInHtml('$20.82');
    }

    public function test_delivery_form_without_an_order_goes_back_to_the_cart()
    {
        $this->createCheckoutPage(true);

        $this->correctlyFillDeliveryForm()->assertRedirect('/cart');
    }

    public function test_delivery_form_should_show_after_contact_info()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $this->correctlyFillCheckoutForm();

        $response = $this->get('/checkout/delivery');

        // check for form fields and title
        $response->assertSee('Delivery Details');
        $response->assertSee('Address');
        $response->assertSee('Suburb');
        $response->assertSee('Postcode');
        $response->assertSee('State');
    }

    public function test_delivery_form_should_be_validated()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $this->correctlyFillCheckoutForm();

        $response = $this->post('/checkout/delivery', [
            'address' => '',
            'suburb' => '',
            'postcode' => '',
            'state' => '',
        ]);

        $response->assertSessionHasErrors('line1');
        $response->assertSessionHasErrors('city');
        $response->assertSessionHasErrors('postcode');
    }

    public function test_correct_delivery_form_should_redirect_to_payment()
    {
        // turn off exception handling
        $this->withoutExceptionHandling();

        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $this->correctlyFillCheckoutForm();

        $response = $this->correctlyFillDeliveryForm();

        $response->assertRedirect('/checkout/card');
    }

    public function test_payment_form_should_show_after_delivery_form()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $this->correctlyFillCheckoutForm();

        $this->correctlyFillDeliveryForm();

        $response = $this->get('/checkout/card');

        // check for card form fields
        $response->assertSee('Credit Card');
        $response->assertSee('Card Number');
        $response->assertSee('Month');
        $response->assertSee('Year');
        $response->assertSee('CVC');

        // check for direct deposit
        $response->assertSee('Direct Deposit');
    }

    public function test_direct_deposit_link_should_show_correct_info()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $this->correctlyFillCheckoutForm();

        $this->correctlyFillDeliveryForm();

        $response = $this->get('/checkout/directdeposit');

        $response->assertSee('Your order number is');
        $response->assertSee('John Doe');
    }

    public function test_payment_form_should_be_validated()
    {
        $this->createCheckoutPage(true);

        // add product to cart
        $this->correctlyFillCart();

        $this->correctlyFillCheckoutForm();

        $this->correctlyFillDeliveryForm();

        $response = $this->post('/checkout/card', [
            'number' => '',
            'month' => '',
            'year' => '',
            'cvc' => '',
        ]);

        $response->assertSessionHasErrors('number');
        $response->assertSessionHasErrors('cvc');
    }

    // public function test_correct_payment_form_should_redirect_to_confirmation()
    // {
    //     $this->createCheckoutPage(true);


    //     // add product to cart
    //     $this->correctlyFillCart();

    //     $this->correctlyFillCheckoutForm();

    //     $this->correctlyFillDeliveryForm();

    //     $response = $this->correctlyFillPaymentForm();

    //     $response->assertRedirect('/checkout/thankyou');

    //     // dump($response->getContent());
    // }
}
