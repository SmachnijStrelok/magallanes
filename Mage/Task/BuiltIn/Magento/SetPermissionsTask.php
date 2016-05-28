<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) Hector Nguyen <hectornguyen@octopius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task\BuiltIn\Magento;

use Mage\Task\BuiltIn\Magento\MagentoAbstractTask;

/**
 * Task for Magento 2 Set Permission
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
class SetPermissionsTask extends MagentoAbstractTask
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Magento 2 - Set Permissions [built-in]';
    }

    /**
     * Clears Cache
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $command = 'find . -type d -print0 | xargs -0 chmod 0755';
        $result = $this->runCommand($command);

        $command = 'find . -type f -print0 | xargs -0 chmod 0644';
        $result = $this->runCommand($command);

        $command = 'chmod u+x bin/magento';
        $result = $this->runCommand($command);

        return $result;
    }
}
