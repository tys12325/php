<?php

require_once 'OrderCommand.php';

class CancelOrderCommand {
    private $order;
    private $orderRepository;

    public function __construct(Order $order, OrderRepositoryImpl $orderRepository) {
        $this->order = $order;
        $this->orderRepository = $orderRepository;
    }

    public function execute() {
        $this->orderRepository->cancelOrder($this->order);
    }
}
