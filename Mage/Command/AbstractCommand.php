<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) J.Moriarty <moriarty@codefelony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Command;

use Mage\Config;

/**
 * Abstract Class for a Magallanes Command
 *
 * @author J.Moriarty <moriarty@codefelony.com>
 */
abstract class AbstractCommand
{
    /**
     * Instance of the loaded Configuration.
     *
     * @var \Mage\Config
     */
    protected $config = null;

    /**
     * Runs the Command
     * @return integer exit code
     * @throws \Exception
     */
    abstract public function run();

    /**
     * Sets the Loaded Configuration.
     *
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Gets the Loaded Configuration.
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
