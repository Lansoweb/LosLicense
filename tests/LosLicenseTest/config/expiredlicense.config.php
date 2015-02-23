<?php
use \LosLicense\License\LicenseInterface;

$conf = [
    'license' => [
        'type' => LicenseInterface::LICENSE_TRIAL,
        'valid_until' => (new DateTime('-1 day'))->format('Y-m-d'),
    ],
];

return [
    'loslicense' => $conf,
];
