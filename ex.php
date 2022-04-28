<?php
    $idx = 3;
    if(!isset($_COOKIE["article_$idx"])){
        setcookie("article_$idx", $idx, time() + 60);
    }

?>