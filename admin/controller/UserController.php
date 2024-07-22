<?php

namespace Admin\Controller;

class UserController
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