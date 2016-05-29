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
 * Abstract Task for Magento
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
abstract class MagentoAbstractTask extends AbstractTask
{
    protected function getAppPath($memoryLimit = true)
    {
        $phpCmd = $this->getParameter('php_cmd', $this->getConfig()->general('php_cmd', 'php '));
        $phpCmd = ($memoryLimit) ? $phpCmd . ' -dmemory_limit=-1 -f ' : ' -f ';
        if ($this->getConfig()->extras('magento', 'version', '1') === '2') {
            $defaultAppPath = $phpCmd . 'bin/magento';
        } else {
            $defaultAppPath = $phpCmd . 'bin/magerun';
        }

        return $this->getConfig()->extras('magento', 'app_path', $defaultAppPath);
    }
}
