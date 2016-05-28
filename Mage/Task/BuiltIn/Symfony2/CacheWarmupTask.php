<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) Hector Nguyen <hectornguyen@octopius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task\BuiltIn\Symfony2;

use Mage\Task\BuiltIn\Symfony2\SymfonyAbstractTask;

/**
 * Task for Warming Up the Cache
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
class CacheWarmupTask extends SymfonyAbstractTask
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Symfony v2 - Cache Warmup [built-in]';
    }

    /**
     * Warms Up Cache
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        // Options
        $env = $this->getParameter('env', 'dev');

        $command = $this->getAppPath() . ' cache:warmup --env=' . $env;
        $result = $this->runCommand($command);

        return $result;
    }
}
