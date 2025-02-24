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
		// Enable the extension
		$this->enablePlugin();

		return true;
	}

	private function enablePlugin()
	{
		try
		{
			$db    = Factory::getContainer()->get('DatabaseDriver');
			$query = $db->getQuery(true)
				->update($db->qn('#__extensions'))
				->set($db->qn('enabled') . ' = ' . $db->q(1))
				->where('type = ' . $db->q('plugin'))
				->where('folder = ' . $db->q('content'))
				->where('element = ' . $db->q('socialshare'));
			$db->setQuery($query);
			$db->execute();
		}
		catch (\Exception $e)
		{
			return;
		}
	}
}