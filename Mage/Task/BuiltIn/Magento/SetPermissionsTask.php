<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) J.Moriarty <moriarty@codefelony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task\BuiltIn\Magento;

use Mage\Task\AbstractTask;

/**
 * Task for Magento 2 Set Permission
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
class SetPermissionsTask extends AbstractTask
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
        $command = 'chmod u+x bin/magento';
        $result = $this->runCommandRemote($command);

        return $result;
    }
}
