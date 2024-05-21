<?php

namespace Botble\Ecommerce\Repositories\Eloquent;

use Botble\Ecommerce\Repositories\Interfaces\EmployeeInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class EmployeeRepository extends RepositoriesAbstract implements EmployeeInterface
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
