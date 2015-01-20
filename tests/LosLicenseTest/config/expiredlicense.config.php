<?php
use \LosLicense\License\License;

$conf = [
    'license' => [
        'type' => License::LICENSE_TRIAL,
        'valid_until' => (new DateTime('-1 day'))->format('Y-m-d'),
    ],
];

return [
    'loslicense' => $conf
];
