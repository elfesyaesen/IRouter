<?php

namespace Catalog\Controller;

class ProductController
{
    public function index()
    {
        echo "ProductController index!";
    }

    public function show(int $id)
    {
        print 'product id: '.($id);
    }
}