<?php
$hooks->afterScenario('', function($event){
    Router::reload();
});
?>
