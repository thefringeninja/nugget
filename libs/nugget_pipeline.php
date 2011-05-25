<?php
class NuggetPipeline {
    private $items = array();
    function first($callback) {
        array_unshift($this->items, $callback);
    }

    function last($callback) {
        $this->items[] = $callback;
    }

    function enumerate() {
        return $this->items;
    }

    function combine(NuggetPipeline $pipeline) {
        $this->items = array_merge($this->items, $pipeline->items);
    }
}
?>
