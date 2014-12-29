<?php
use \LosLicense\License\License;

$conf = [
    'license' => [
        'type' => License::LICENSE_TRIAL,
        'valid_from' => (new DateTime('+1 day'))->format('Y-m-d'),
    ],
];

return array(
    'loslicense' => $conf
);
