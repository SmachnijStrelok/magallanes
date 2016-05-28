<?php

/**
 * This file is part of the Magallanes package.
 *
 * (c) Hector Nguyen <hectornguyen@octopius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task\BuiltIn\Deployment\Strategy;

use Mage\Task\AbstractTask;
use Mage\Task\Releases\IsReleaseAware;

/**
 * Abstract Base task to concentrate common code for Deployment Tasks
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
abstract class BaseStrategyTaskAbstract extends AbstractTask implements IsReleaseAware
{
    /**
     * Checks if there is an override underway
     *
     * @return bool
     */
    protected function checkOverrideRelease()
    {
        $overrideRelease = $this->getParameter('overrideRelease', false);
        $symlink         = $this->getConfig()->release('symlink', 'public');

        if ($overrideRelease === true) {
            $releaseToOverride = false;
            $resultFetch       = $this->runCommandRemote('ls -ld ' . $symlink . ' | cut -d"/" -f2', $releaseToOverride);
            if ($resultFetch && is_numeric($releaseToOverride)) {
                $this->getConfig()->setReleaseId($releaseToOverride);
            }
        }

        return $overrideRelease;
    }

    /**
     * Gathers the files to exclude
     *
     * @return array
     */
    protected function getExcludes()
    {
        $excludes = array(
            '.git*',
            '.svn*',
            '.mage',
            '.rsync_excludes',
            'nohup.out',
        );

        // Look for User Excludes
        $userExcludes = $this->getConfig()->deployment('excludes', array());

        return array_merge($excludes, $userExcludes);
    }

    /**
     * Gathers the shared files & folders
     *
     * @return array
     */
    protected function getSharedStuffs()
    {
        $sharedFiles = $this->getConfig()->extras('shared', 'linked_files', array());

        $sharedFolders = $this->getConfig()->extras('shared', 'linked_folders', array());

        return array_merge($sharedFiles, $sharedFolders);
    }

    /**
     * Gathers extras/vcs properties
     *
     * @return array
     */
    protected function getExtraVcs()
    {
        $extraVcsProperties = $this->getConfig()->extras('vcs', 'top', array());

        return $extraVcsProperties;
    }

    /**
     * Gathers extras/rsync properties
     *
     * @return array
     */
    protected function getExtraRsync()
    {
        $extraRsyncProperties = $this->getConfig()->extras('rsync', 'top', array());

        return $extraRsyncProperties;
    }
}
