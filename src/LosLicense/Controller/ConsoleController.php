<?php
namespace LosLicense\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Console;
use Zend\Console\ColorInterface as Color;
use Zend\Console\Exception\RuntimeException as ConsoleException;
use Zend\Console\Prompt\Line;
use Zend\Console\Prompt\Select;
use Zend\Console\Prompt\Confirm;
use LosLicense\License\License;
use LosLicense\Console\Prompt\Checkbox;
use LosLicense\Service\ValidatorServiceAwareTrait;
use LosLicense\License\TrialLicense;
use LosLicense\License\PersonalLicense;
use LosLicense\License\StandardLicense;

class ConsoleController extends AbstractActionController
{
    use ValidatorServiceAwareTrait;

    public function createAction()
    {
        $request = $this->getRequest();

        if (! $request instanceof ConsoleRequest) {
            throw new \RuntimeException('This action can only be used from a console!');
        }

        try {
            $console = Console::getInstance();
        } catch (ConsoleException $e) {
            throw new \RuntimeException('This action can only be used from a console!');
        }

        $this->setValidatorService($this->getServiceLocator()->get('loslicense.validator'));

        $outputFile = $request->getParam('outputFile',null);

        $writer = new \LosLicense\Config\Writer\PhpArray();
        $writer->setUseBracketArraySyntax(true);

        $options = [
            'Trial',
            'Personal',
            'Standard'
        ];

        $type = Select::prompt('License type?', $options, false, true);

        $valid_from = Line::prompt("\nValid from (Enter to not set one) YYYY-MM-DD HH:II:SS ? ", true, 20);
        $valid_until = Line::prompt("\nValid until (Enter to not set one) YYYY-MM-DD HH:II:SS ? ", true, 20);

        $customer = Line::prompt("\nCustomer? ", true, 100);

        $options = $this->getServiceLocator()->get('loslicense.options');
        $features = $options->getFeatures();

        $checked = Checkbox::prompt("\nFeatures? (Enter to finish) ", array_keys($features), true, true);

        $sign = false;
        if (Confirm::prompt("\nSign the license? [y/n] ", 'y', 'n')) {
            $sign = true;
        }

        if (Confirm::prompt("\nConfirm the license creation? [y/n] ", 'y', 'n')) {
            $data = [];
            $config = new \Zend\Config\Config([], true);

            if ($type == 0) {
                $config->type = License::LICENSE_TRIAL;
                $license = new TrialLicense();
            } elseif ($type == 1) {
                $config->type = License::LICENSE_PERSONAL;
                $license = new PersonalLicense();
            } else {
                $config->type = License::LICENSE_STANDARD;
                $license = new StandardLicense();
            }

            $license->setType($config->type);

            if (!empty($valid_from)) {
                $from = new \DateTime($valid_from);
                $config->valid_from = $from->format('Y-m-d H:i:s');
                $license->setValidFrom($config->valid_from);
            }

            if (!empty($valid_until)) {
                $until = new \DateTime($valid_until);
                $config->valid_until = $until->format('Y-m-d H:i:s');
                $license->setValidUntil($config->valid_until);
            }

            if (!empty($customer)) {
                $config->customer = $customer;
                $license->setCustomer($config->customer);
            }

            if (!empty($checked)) {
                $config->features = [];
                $licenseFeatures = [];
                foreach ($features as $feature => $value) {
                    if (in_array($feature, $checked)) {
                        if ($value === null) {
                            $config->features->$feature = null;
                            $licenseFeatures[$feature] = null;
                        } else {
                            $config->features->$feature = $value;
                            $licenseFeatures[$feature] = $value;
                        }
                    }
                }
                $license->setFeatures($licenseFeatures);
            }

            if ($sign) {
                $signature = $this->getValidatorService()->signLicense($license);
                $config->signature = $signature;
            }

            if ($outputFile) {
                $writer->toFile($outputFile, $config);
            } else {
                echo $writer->toString($config);
            }
            $console->writeLine("License created", Color::GREEN);
        }
    }
}
