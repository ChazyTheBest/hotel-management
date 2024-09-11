<?php

namespace App\Traits;

use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

trait HasDeviceDetector
{
    /**
     * Create a new DeviceDetector instance from the given session.
     *
     * @param string $userAgent
     * @return DeviceDetector
     */
    protected function deviceDetector(string $userAgent): DeviceDetector
    {
        // Set version truncation to none, so full versions will be returned
        // By default only minor versions will be returned (e.g. X.Y)
        // for other options see VERSION_TRUNCATION_* constants in DeviceParserAbstract class
        AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

        $clientHints = ClientHints::factory($_SERVER);

        $dd = new DeviceDetector($userAgent, $clientHints);
        $dd->skipBotDetection();
        $dd->parse();

        return $dd;
    }
}
