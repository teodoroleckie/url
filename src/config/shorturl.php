<?php

return [
    'pattern' => '/^[{}()\[\]]+$/',
    'nestedTags'=> ['{' => '}', '[' => ']', '(' => ')'],
    'shortenEndpoint' => 'https://tinyurl.com/api-create.php?url='
];
