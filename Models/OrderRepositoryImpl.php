<?php
//Author: Tan Yen Shi 22WMR13751
require_once 'OrderRepository.php';

// Order/OrderRepositoryImpl.php
class OrderRepositoryImpl {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveOrder(Order $order) {
        $orderInsertQuery = "INSERT INTO `Orderr` (OrderID, OrderDate, Status, TotalAmt, userID) VALUES (?, ?, ?, ?, ?)";
        $orderStmt = $this->pdo->prepare($orderInsertQuery);
        $orderStmt->execute([$order->getOrderID(), $order->getOrderDate(), $order->getStatus(), $order->getTotalAmt(), $order->getCustomerID()]);
    }

    public function saveOrderItem(OrderItem $orderItem) {
        $orderItemInsertQuery = "INSERT INTO OrderItem (OrderItemID, OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?, ?)";
        $orderItemStmt = $this->pdo->prepare($orderItemInsertQuery);
        $orderItemStmt->execute([$orderItem->getOrderItemID(), $orderItem->getOrderID(), $orderItem->getProductID(), $orderItem->getQuantity(), $orderItem->getPrice()]);
    }

    public function updateOrder(Order $order) {
        $updateOrderQuery = "UPDATE `Orderr` SET Status = 'Completed' WHERE OrderID = ?";
        $updateOrderStmt = $this->pdo->prepare($updateOrderQuery);
        $updateOrderStmt->execute([$order->getOrderID()]);
    }


}

