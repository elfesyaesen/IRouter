<?php

namespace Catalog\Controller;

class ProductController
{
    public function index(): void
    {
        echo "ProductController index metodu...";
    }

    public function show(int $id): void
    {
        print 'ProductController show metodu. product id: '.$id;
    }
}