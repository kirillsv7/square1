<?php

namespace App\Contracts;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function indexByAuthUser();

    public function getByAuthUser(int $id);
}