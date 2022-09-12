<?php

namespace App;

use App\Exceptions\NotCatalogedItemException;
use Illuminate\Support\Collection;
use Money\Money;

class Catalog
{
    private Collection $priceList;

    public function __construct()
    {
        $this->priceList = new Collection();
    }

    public function set(string $name, Money $price): void
    {
        $this->priceList->put($name, $price);
    }

    public function price(string $name): Money
    {
        /** @var null|Money $price */
        $price = $this->priceList->get($name);

        if ($price) {
            return $price;
        }

        throw new NotCatalogedItemException();
    }
}
