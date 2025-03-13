<?php
//Author: Tan Yen Shi 22WMR13751
interface OrderRepository {
    public function saveOrder(Order $order);
    public function updateOrder(Order $order);
    public function getAllOrders();
}
