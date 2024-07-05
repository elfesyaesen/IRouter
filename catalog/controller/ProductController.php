<?php

namespace Catalog\Controller;

class ProductController
{
    public function index()
    {
        echo "ProductController index metodu...";
    }

    public function show(int $id)
    {
        print 'ProductController show metodu. product id: '.$id;
    }
}