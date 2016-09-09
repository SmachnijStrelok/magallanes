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
 * Task for Production environment setup
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
class ProductionSetupTask extends MagentoAbstractTask
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
     * Multiple things going happen...
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $command = $this->getAppPath() . ' setup:upgrade';
        $result = $this->runCommand($command);

        $command = $this->getAppPath() . ' setup:static-content:deploy vi_VN en_US';
        $result = $this->runCommand($command);

		$command = $this->getAppPath() . ' setup:di:compile';
        $result = $this->runCommand($command);

        $command = $this->getAppPath() . ' cache:flush';
        $result = $this->runCommand($command);

        return $result;
    }
}
