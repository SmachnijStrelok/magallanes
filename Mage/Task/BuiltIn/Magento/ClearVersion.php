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
 * Task for Clearing Full Page Cache
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
class ClearVersionTask extends MagentoAbstractTask
{
    /**
     * Returns Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Magento - Clear Version [built-in]';
    }

    /**
     * Clears Version and Edition of Magento
     *
     * @return boolean
     * @throws Exception
     * @throws ErrorWithMessageException
     * @throws SkipException
     */
    public function run()
    {
        if ($this->getConfig()->extras('magento', 'enabled', false) === true) {
            $magentoRootDirectory = $this->getConfig()->extras('magento', 'root', 'public');

            $mageVersionFiles = array(
                "LICENSE.html",
                "LICENSE.txt",
                "LICENSE_EE.html",
                "LICENSE_EE.txt",
                "LICENSE_AFL.txt",
                "RELEASE_NOTES.txt",
            );

            $command = 'rm -f ' . $this->version($mageVersionFiles, $magentoRootDirectory);
            $result  = $this->runCommand($command);
        }

        return $result;
    }

    /**
     * Generate Magento version & edition files
     *
     * @param array $versions
     * @return string
     */
    protected function version(array $versions, $dir)
    {
        $deleteObj = '';
        foreach ($versions as $obj) {
            $deleteObj .= $dir . '/' . escapeshellarg($obj) . ' ';
        }

        $deleteObj = trim($deleteObj);
        return $deleteObj;
    }
}
