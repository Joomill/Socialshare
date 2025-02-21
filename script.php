<?php
/*
 *  package: Joomill - Social Share
 *  copyright: Copyright (c) 2025. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 2 or later
 *  link: https://www.joomill-extensions.com
 */

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class plgContentsocialshareInstallerScript
{
	public function install($parent)
	{
		jimport('joomla.filesystem.file');
        Factory::getDBO()->setQuery("UPDATE `#__extensions` SET `enabled` = 1 WHERE `type` = 'plugin' AND`element` = 'socialshare'")->execute();
	}
}