<?php
require_once __DIR__ . '/../models/product.php';

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new Product();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? $_POST['action'] ?? '';

        switch ($action) {
            case 'add':
                $this->addProduct();
                break;
            case 'delete':
                $this->deleteProduct();
                break;
            default:
                $this->listProducts();
                break;
        }
    }

    private function listProducts() {
        $products = $this->model->getAllProducts();
        require __DIR__ . '/../views/index.php';
    }

    private function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $description = $_POST['description'] ?? '';

            if ($name && $price) {
                $this->model->addProduct($name, $price, $description);
            }
        }
        header('Location: index.php');
        exit();
    }

    private function deleteProduct() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->model->deleteProduct($id);
        }
        header('Location: index.php');
        exit();
    }
}
