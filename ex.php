<?php
    $referer = getenv("HTTP_REFERER");
    $host = getenv("HTTP_HOST");
    $parsedReferer = getenv($referer);
    $refererHost = $parsedReferer['host'];

    var_dump($host === $refererHost);
    
?>