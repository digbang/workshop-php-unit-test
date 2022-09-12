<?php

namespace App;

use App\Exceptions\NotInCartItemException;
use App\Item;
use Illuminate\Support\Collection;

class Cart
{
    private Collection $items;

    public function __construct()
    {
        $this->items = new Collection();
    }

    public function add(string $name, int $quantity): void
    {
        $currentQuantity = (int) $this->items->get($name);
        $newQuantity = $currentQuantity + $quantity;

        $this->items->put($name, $newQuantity);
    }

    public function contains(string $name): bool
    {
        return $this->items->has($name);
    }

    public function items(): array
    {
        return $this->items->toArray();
    }

    public function quantity(string $name): int
    {
        if ($this->contains($name)) {
            return (int) $this->items->get($name);
        }

        throw new NotInCartItemException();
    }
}
