<?php

namespace Catalog\Controller;

class ProductController
{
    public function index()
    {
        echo "ProductController index!";
    }

    public function show($id)
    {
        var_dump($id);
    }
}