<?php

namespace Botble\Ecommerce\Repositories\Eloquent;

use Botble\Ecommerce\Repositories\Interfaces\DeliveryPickUpInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class DeliveryPickupRepository extends RepositoriesAbstract implements DeliveryPickUpInterface
{
    public function getAll(array $condition = [])
    {
        $data = $this->model
            ->where($condition)
            ->orderBy('is_featured', 'DESC')
            ->orderBy('name', 'ASC');

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
