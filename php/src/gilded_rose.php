<?php

class GildedRose {

    private $items;

    function __construct($items) {
        $this->items = $items;
    }

    function update_quality() {
        foreach ($this->items as $item) {
            $item->sell_in += $this->calc_sell_in_delta($item);
            $item->quality += $this->calc_quality_delta($item);
        }
    }
    
    function calc_sell_in_delta(Item $item) {
        switch ($item->name) {
            case 'Sulfuras, Hand of Ragnaros';
                return 0;

            default:
                return -1;
        }
    }

    function calc_quality_delta(Item $item) {
        $delta = 0;

        // Initial delta
        switch ($item->name) {
            case 'Sulfuras, Hand of Ragnaros';
                return 0;

            case 'Aged Brie';
                $delta = 1;
                break;

            case 'Conjured Mana Cake';
                $delta = -2;
                break;

            case 'Backstage passes to a TAFKAL80ETC concert';
                $delta = 1;
                break;

            default:
                $delta = -1;
                break;
        }
        
        // Increase delta by sell_in
        switch ($item->name) {
            case 'Backstage passes to a TAFKAL80ETC concert';
                if ($item->sell_in < 0) {
                    $delta = - $item->quality;
                } elseif ($item->sell_in < 5) {
                    $delta = 3;
                } elseif ($item->sell_in < 10) {
                    $delta = 2;
                }
                break;
                
            default:
                if ($item->sell_in < 0) {
                    $delta *= 2;
                }
                break;
        }
        
        // Maximum is 50
        $delta = min($delta, 50 - $item->quality);
        
        // Minimum is 0
        $delta = max($delta, 0 - $item->quality);
        
        return $delta;
    }

}

class Item {

    public $name;
    public $sell_in;
    public $quality;

    function __construct($name, $sell_in, $quality) {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString() {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

}

