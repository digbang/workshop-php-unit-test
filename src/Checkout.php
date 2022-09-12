<?php

namespace App;

use App\Exceptions\EmptyCartDuringCheckoutException;
use Money\Money;
use App\Exceptions\NotCatalogedItemException;

class Checkout
{
    /**
     * @throws NotCatalogedItemException
     */
    public function __invoke(Cart $cart, Catalog $catalog)
    {
        $this->assertEmptyCart($cart);

        $total = Money::ARS(0);

        foreach ($cart->items() as $name => $quantity) {
            $total = $total->add($catalog->price($name)->multiply($quantity));
        }

        return $total;
    }

    private function assertEmptyCart(Cart $cart): void
    {
        if (empty($cart->items())) {
            throw new EmptyCartDuringCheckoutException();
        }
    }
}
