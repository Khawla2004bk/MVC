<?php
class Product {
    private static $products = [];
    private static $nextId = 1;

    public function getAllProducts() {
        return self::$products;
    }

    public function addProduct($name, $price, $description) {
        $product = [
            'id' => self::$nextId++,
            'name' => htmlspecialchars(trim($name)),
            'price' => floatval($price),
            'description' => htmlspecialchars(trim($description))
        ];
        self::$products[] = $product;
        return $product['id'];
    }

    public function deleteProduct($id) {
        self::$products = array_filter(self::$products, function($product) use ($id) {
            return $product['id'] != $id;
        });
    }
}
