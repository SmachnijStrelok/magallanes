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

use Mage\Console;
use Mage\Task\Releases\IsReleaseAware;

/**
 * The git remote cache deployment task.
 *
 * This tasks uses a remote checkout on the server to provide the release.
 * In our use case this remote cache resides in $to/$shared/git-remote-cache,
 * $shared is substituted with "shared" by default. At this time, the remote cache
 * is not build automatically, you need to provide a clean checkout before you can
 * start using it.
 *
 * @package Mage\Task\BuiltIn\Deployment\Strategy
 * @author James Moriarty <moriarty@codefelony.com>
 */
class GitRemoteCacheTask extends BaseStrategyTaskAbstract implements IsReleaseAware
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        if ($this->getConfig()->release('enabled', false) === true) {
            if ($this->getConfig()->getParameter('overrideRelease', false) === true) {
                return 'Deploy via remote cache git repository (with Releases override) [built-in]';
            } else {
                return 'Deploy via remote cached git repository (with Releases) [built-in]';
            }
        } else {
            return 'Deploy via remote cached git repository [built-in]';
        }
    }

    /**
     * Runs the task
     *
     * @return boolean
     * @throws Exception
     * @throws ErrorWithMessageException
     * @throws SkipException
     */
    public function run()
    {
        $this->checkOverrideRelease();

        // If we are working with releases
        $deployToDirectory = $this->getConfig()->deployment('to');
        if ($this->getConfig()->release('enabled', false) === true) {
            $releasesDirectory = $this->getConfig()->release('directory', 'releases');
            $symlink           = $this->getConfig()->release('symlink', 'public');

            $currentRelease    = false;
            $deployToDirectory = rtrim($deployToDirectory, '/') . '/' . $releasesDirectory . '/' . $this->getConfig()->getReleaseId();
            Console::log('Deploy to ' . $deployToDirectory);
            $resultFetch = $this->runCommandRemote('ls -ld ' . $symlink . ' | cut -d"/" -f2', $currentRelease);

            if ($resultFetch && $currentRelease) {
                // If deployment configuration is rsync, include a flag to
                // simply sync the deltas between the prior release
                $rsync_copy = $this->getConfig()->extras('vcs', 'rsync'); // rsync: { copy: yes }
                // If copy_tool_rsync, use rsync rather than cp for finer control of what is copied
                if ($rsync_copy && is_array($rsync_copy) && $rsync_copy['copy'] && $this->runCommandRemote('test -d ' . $releasesDirectory . '/' . $currentRelease)) {
                    if (isset($rsync_copy['copy_tool_rsync'])) {
                        $this->runCommandRemote("rsync -a {$this->excludes(array_merge($excludes, $rsync_copy['rsync_excludes']))} "
                            . "$releasesDirectory/$currentRelease/ $releasesDirectory/{$this->getConfig()->getReleaseId()}");
                    } else {
                        $this->runCommandRemote('cp -R ' . $releasesDirectory . '/' . $currentRelease . ' ' . $releasesDirectory . '/' . $this->getConfig()->getReleaseId());
                    }
                } else {
                    $this->runCommandRemote('mkdir -p ' . $releasesDirectory . '/' . $this->getConfig()->getReleaseId());
                }
            }
        }

        $branch = $this->getConfig()->extras('vcs', 'branch', 'master');
        $remote = $this->getConfig()->extras('vcs', 'remote', 'origin');

        $sharedDirectory   = $this->getConfig()->extras('directory', 'top', 'shared');
        $cacheDirectory    = $this->getConfig()->extras('vcs', 'directory', 'git-remote-cache');
        $remoteCacheFolder = rtrim($this->getConfig()->deployment('to'), '/')
        . '/' . $sharedDirectory
        . '/' . $cacheDirectory;
        $this->runCommandRemote('mkdir -p ' . $remoteCacheFolder);

        // Fetch Remote
        $command = $this->getGitCacheAwareCommand('git fetch ' . $remote);
        $result  = $this->runCommandRemote($command);

        if ($result === false) {
            $repository = $this->getConfig()->extras('vcs', 'repository');
            if ($repository) {
                $command = $this->getGitCacheAwareCommand('git clone --mirror ' . $repository . ' .');
                $result  = $this->runCommandRemote($command);

                $command = $this->getGitCacheAwareCommand('git fetch ' . $remote);
                $result  = $this->runCommandRemote($command);
            }
        }

        // Archive Remote
        $command = $this->getGitCacheAwareCommand('git archive ' . $branch . ' | tar -x -C ' . $deployToDirectory);
        $result  = $this->runCommandRemote($command) && $result;

        return $result;
    }

    /**
     * Generates extra vcs property
     * @param array $options
     * @param string $property
     * @return string
     */
    protected function vcs(array $options, $chosen)
    {
        $vcsPropertyContent = null;
        foreach ($options as $properties) {
            foreach ($properties as $property) {
                $vcsPropertyContent = $property[$chosen];
            }
        }

        return $vcsPropertyContent;
    }

    /**
     * Generates extra rsync property
     * @param array $options
     * @param string $property
     * @return string
     */
    protected function rsync(array $options, $chosen)
    {
        $rsyncPropertyContent = null;
        foreach ($options as $properties) {
            foreach ($properties as $property) {
                $vcsPropertyContent = $property[$chosen];
            }
        }

        return $rsyncPropertyContent;
    }
}
