<?php
//Name: SIA YAO QING ID:22WMR13745
class GoldPriceSubject {
    private $observers = [];  // List of product observers
    private $goldPrice;

    // Attach (register) an observer (ProductObserver)
    public function attach(ProductObserver $observer) {
        $this->observers[] = $observer;
    }

    // Detach (remove) an observer
    public function detach(ProductObserver $observer) {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    // Notify all observers when the gold price changes
    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this->goldPrice);
        }
    }

    // Set a new gold price and notify all observers
    public function setGoldPrice($newPrice) {
        $this->goldPrice = $newPrice;
        $this->notify();  // Notify all observers (products)
    }

    // Get the current gold price
    public function getGoldPrice() {
        return $this->goldPrice;
    }
}
