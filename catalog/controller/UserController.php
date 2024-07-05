<?php

namespace Catalog\Controller;

class UserController
{
    public function index()
    {
        echo "UserController index metodu...";
    }

    public function show($id)
    {
        echo "UserController show metodu: user_id: " . $id;
    }
}