<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Cart;
use App\Catalog;
use App\Checkout;
use App\Exceptions\EmptyCartDuringCheckoutException;
use App\Exceptions\NotCatalogedItemException;
use App\Exceptions\NotInCartItemException;
use Money\Money;
use PHPUnit\Framework\TestCase;

class XTest extends TestCase
{
    public function test_001(): void
    {
        $cart = new Cart();

        $this->assertEmpty($cart->items());
    }

    public function test_002(): void
    {
        $cart = new Cart();
        $cart->add('Item 1', 1);

        $this->assertCount(1, $cart->items());

        $this->assertTrue($cart->contains('Item 1'));

        $this->assertEquals(1, $cart->quantity('Item 1'));
    }

    public function test_003(): void
    {
        $cart = new Cart();
        $cart->add('Item 1', 1);
        $cart->add('Item 1', 1);

        $this->assertCount(1, $cart->items());

        $this->assertTrue($cart->contains('Item 1'));

        $this->assertEquals(2, $cart->quantity('Item 1'));
    }

    public function test_004(): void
    {
        $cart = new Cart();
        $cart->add('Item 1', 1);
        $cart->add('Item 2', 2);

        $this->assertCount(2, $cart->items());

        $this->assertTrue($cart->contains('Item 1'));
        $this->assertTrue($cart->contains('Item 2'));

        $this->assertEquals(1, $cart->quantity('Item 1'));
        $this->assertEquals(2, $cart->quantity('Item 2'));
    }

    public function test_005(): void
    {
        $this->expectException(NotInCartItemException::class);

        $cart = new Cart();

        $this->assertEmpty($cart->items());

        $this->assertFalse($cart->contains('Non in cart item'));
        
        $cart->quantity('Non in cart item');
    }

    public function test_006(): void
    {
        $catalog = new Catalog();
        $catalog->set('Item 1', Money::ARS(10));

        $this->assertEquals(Money::ARS(10), $catalog->price('Item 1'));
    }

    public function test_007(): void
    {
        $catalog = new Catalog();
        $catalog->set('Item 1', Money::ARS(10));
        $catalog->set('Item 1', Money::ARS(50));

        $this->assertEquals(Money::ARS(50), $catalog->price('Item 1'));
    }

    public function test_008(): void
    {
        $catalog = new Catalog();
        $catalog->set('Item 1', Money::ARS(10));
        $catalog->set('Item 2', Money::ARS(50));

        $this->assertEquals(Money::ARS(10), $catalog->price('Item 1'));
        $this->assertEquals(Money::ARS(50), $catalog->price('Item 2'));
    }

    public function test_009(): void
    {
        $this->expectException(NotCatalogedItemException::class);

        $catalog = new Catalog();

        $catalog->price('Not cataloged item');
    }

    public function test_010(): void
    {
        $this->expectException(EmptyCartDuringCheckoutException::class);

        $cart = new Cart();

        $catalog = new Catalog();

        $checkout = new Checkout();
        $checkout($cart, $catalog);
    }

    public function test_011(): void
    {
        $cart = new Cart();
        $cart->add('Item 1', 1);

        $catalog = new Catalog();
        $catalog->set('Item 1', Money::ARS(10));

        $checkout = new Checkout();
        $total = $checkout($cart, $catalog);

        $this->assertEquals(Money::ARS(10), $total);
    }

    public function test_012(): void
    {
        $cart = new Cart();
        $cart->add('Item 1', 1);
        $cart->add('Item 1', 1);

        $catalog = new Catalog();
        $catalog->set('Item 1', Money::ARS(10));

        $checkout = new Checkout();
        $total = $checkout($cart, $catalog);

        $this->assertEquals(Money::ARS(20), $total);
    }

    public function test_013(): void
    {
        $cart = new Cart();
        $cart->add('Item 1', 1);
        $cart->add('Item 2', 1);

        $catalog = new Catalog();
        $catalog->set('Item 1', Money::ARS(10));
        $catalog->set('Item 2', Money::ARS(50));

        $checkout = new Checkout();
        $total = $checkout($cart, $catalog);

        $this->assertEquals(Money::ARS(60), $total);
    }

    public function test_014(): void
    {
        $this->expectException(NotCatalogedItemException::class);

        $cart = new Cart();
        $cart->add('Item 1', 1);

        $catalog = new Catalog();

        $checkout = new Checkout();
        $checkout($cart, $catalog);
    }
}
