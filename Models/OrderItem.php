<?php
//Author: Tan Yen Shi 22WMR13751
// Order/OrderItem.php
class OrderItem {
    private $orderItemID;
    private $orderID;
    private $productID;
    private $quantity;
    private $price;

    public function __construct($orderItemID, $orderID, $productID, $quantity, $price) {
        $this->orderItemID = $orderItemID;
        $this->orderID = $orderID;
        $this->productID = $productID;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    // Getter methods
    public function getOrderItemID() { return $this->orderItemID; }
    public function getOrderID() { return $this->orderID; }
    public function getProductID() { return $this->productID; }
    public function getQuantity() { return $this->quantity; }
    public function getPrice() { return $this->price; }
}
