<?php

class Asset {
    public $name;
    public $ticker;
    public $currency;
    public $averageCost;
    public $currentPrice;
    public $shares;
    public $bookValue;
    public $marketValue;
    public $gainLossD;
    public $gainLossP;

    function initialize($name, $ticker, $currency, $shares, $averageCost) {

        $this->name = $name;
        $this->ticker = $ticker;
        $this->currency = $currency;
        $this->shares = $shares;
        $this->averageCost = $averageCost;

        $_SESSION['ticker'] = $ticker;
        include('getMarketPrice.php');
        $this->currentPrice = $_SESSION['marketPrice'];

        $this->bookValue = $shares*$averageCost;
        $this->marketValue = $shares*($this->currentPrice);

        $this->gainLossD = ($this->marketValue)-($this->bookValue);
        $this->gainLossP = (($this->gainLossD)/($this->bookValue))*100;
    }
}

?>