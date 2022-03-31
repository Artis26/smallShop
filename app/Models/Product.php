<?php
namespace App\Models;

class Product {
    private string $name;
    private float $price;
    private int $count;
    private ?string $createdAt;
    private ?int $id;

    public function __construct(string $name, string $price, string $count, ?string $createdAt = null, ?int $id = null) {
        $this->name = $name;
        $this->price = $price;
        $this->count = $count;
        $this->createdAt = $createdAt;
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getCount(): int {
        return $this->count;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    public function getId(): ?int {
        return $this->id;
    }
}