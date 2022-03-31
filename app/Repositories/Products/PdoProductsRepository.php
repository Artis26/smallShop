<?php
namespace App\Repositories\Products;

use App\Database;
use App\Models\Product;
use PDO;

class PdoProductsRepository implements ProductsRepository {

    public function getById(int $productId): Product {
        $query = Database::connection()->prepare('SELECT * FROM products where id = ?');
        $query->execute([$productId]);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product(
                $row['name'],
                $row['price'],
                $row['count'],
                $row['created_at'],
                $row['id'],
            );
        }
        return $product;
    }

    public function store(Product $product): void {
        $query = Database::connection()->prepare('INSERT INTO products (name, price, count) VALUES (?, ? ,?)');
        $query->execute([$product->getName(), $product->getPrice(), $product->getCount()]);
    }

    public function getAll(): array {
        $query = Database::connection()->prepare('SELECT * FROM products');
        $query->execute();
        $products = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                $row['name'],
                $row['price'],
                $row['count'],
                $row['created_at'],
                $row['id'],
            );
        }
        return $products;
    }

    public function buy(int $productId, int $amount): void {
        $query = Database::connection()->prepare('UPDATE products SET count = count - ? WHERE id = ?');
        $query->execute([$amount, $productId]);
    }
}