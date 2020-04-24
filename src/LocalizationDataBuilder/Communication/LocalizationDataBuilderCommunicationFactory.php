<?php

namespace LocalizationDataBuilder\Communication;

use LocalizationDataBuilder\Config\Config;

class LocalizationDataBuilderCommunicationFactory
{
    /**
     * @return \LocalizationDataBuilder\Config\Config
     */
    public function getConfig(): Config
    {
        return Config::buildConfig();
    }

    /**
     * @return \LocalizationDataBuilder\Communication\Output
     */
    public function createPageRenderer(): Output
    {
        return new Output(
            $this->getConfig()
        );
    }
}