<?php

namespace Botble\Terms;

use Illuminate\Contracts\Support\Arrayable;

class Terms implements Arrayable
{
    protected array $items = [];

    public function push(Terms $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
