<?php

/*
 * This file is part of the Magallanes package.
 *
 * (c) Hector Nguyen <hectornguyen@octopius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task\BuiltIn\General;

use Mage\Task\AbstractTask;

/**
 * Task for running multiple custom commands setting them manually
 *
 * Example of usage:
 *
 * tasks:
 *    on-deploy:
 *       - scm/force-update
 *       - general/manually:
 *          - find . -type d -exec chmod 755 {} \;
 *          - find . -type f -exec chmod 644 {} \;
 *          - chmod +x bin/console
 *          - find var/logs -maxdepth 1 -type f -name '*.log' -exec chown apache:apache {} \;
 *       - symfony2/cache-clear
 *
 * @author Samuel Chiriluta <samuel4x4@gmail.com>
 */
class ManuallyTask extends AbstractTask
{

    /**
     * Get the task name
     */
    public function getName()
    {
        return 'Manually multiple custom tasks';
    }

    /**
     * Execute all commands
     *
     * Usage:
     * - general/manually:
     *   - rm -rf /
     *   - shutdown -h -s
     */
    public function run()
    {
        $result = true;

        $commands = $this->getParameters();

        foreach ($commands as $command) {
            $result = $result && $this->runCommand($command);
        }

        return $result;
    }
}
