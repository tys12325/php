<?php
//Author: Tan Yen Shi 22WMR13751
// Order/Order.php
class Order {
    private $orderID;
    private $orderDate;
    private $status;
    private $totalAmt;
    private $userID;

    public function __construct($orderID, $orderDate, $status, $totalAmt, $userID) {
        $this->orderID = $orderID;
        $this->orderDate = $orderDate;
        $this->status = $status;
        $this->totalAmt = $totalAmt;
        $this->userID = $userID;
    }

    // Getter methods
    public function getOrderID() { return $this->orderID; }
    public function getOrderDate() { return $this->orderDate; }
    public function getStatus() { return $this->status; }
    public function getTotalAmt() { return $this->totalAmt; }
    public function getCustomerID() { return $this->userID; }

    public function executeCommand($command) {
        $command->execute();
    }
}

