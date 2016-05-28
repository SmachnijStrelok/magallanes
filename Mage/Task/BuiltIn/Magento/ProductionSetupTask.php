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

use Mage\Task\AbstractTask;

/**
 * Task for Production environment setup
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
class ProductionSetupTask extends AbstractTask
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Magento 2 - Production Setup [built-in]';
    }

    /**
     * Clears Cache
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $command = 'php5.6-sp -f bin/magento setup:upgrade 2&>1';
        $result = $this->runCommandRemote($command);

        $command = 'php5.6-sp -dmemory_limit=-1 -f bin/magento setup:static-content:deploy en_US 2&>1';
        $result = $this->runCommandRemote($command);

        $command = 'php5.6-sp -dmemory_limit=-1 -f bin/magento setup:static-content:deploy vi_VN 2&>1';
        $result = $this->runCommandRemote($command);

		$command = 'php5.6-sp -dmemory_limit=-1 -f bin/magento setup:di:compile-multi-tenant 2&>1';
		$result = $this->runCommandRemote($command);

        return $result;
    }
}
