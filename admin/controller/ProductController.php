<?php

namespace Admin\Controller;

class ProductController extends BaseController
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