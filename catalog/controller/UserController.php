<?php

namespace Catalog\Controller;

class UserController
{
    public function index()
    {
        echo "Welcome to the User Page!";
    }

    public function show($id)
    {
        echo "User ID: " . htmlspecialchars($id);
    }
}
