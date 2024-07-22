<?php

namespace Catalog\Controller;

class UserController extends BaseController
{
    public function index(): void
    {
        echo "UserController index metodu...";
    }

    public function show($id): void
    {
        echo "UserController show metodu: user_id: " . $id;
    }
}