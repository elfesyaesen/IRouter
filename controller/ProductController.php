<?php
namespace Controller;

use Model\ProductModel;

class ProductController {
    public function show($id) {
       $ProductModel = new ProductModel();
       $product = $ProductModel->product($id);
        

       require_once __DIR__ . '/../view/product.php';
    }
}
?>
