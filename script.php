<?php
/*
 *  package: Joomill - Social Share
 *  copyright: Copyright (c) 2025. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;

class SocialshareInstallerScript implements InstallerScriptInterface
{
	private string $minimumJoomlaVersion = '4.0';
	private string $minimumPHPVersion    = JOOMLA_MINIMUM_PHP;

	public function preflight(string $type, InstallerAdapter $adapter): bool
	{
		if ($type !== 'uninstall')
		{
			if (!empty($this->minimumPHPVersion) && version_compare(PHP_VERSION, $this->minimumPHPVersion, '<'))
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_MINIMUM_PHP', $this->minimumPHPVersion),
					Log::WARNING,
					'jerror'
				);

				return false;
			}

			if (!empty($this->minimumJoomlaVersion) && version_compare(JVERSION, $this->minimumJoomlaVersion, '<'))
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomlaVersion),
					Log::WARNING,
					'jerror'
				);

				return false;
			}
		}

		return true;
	}

	public function postflight(string $type, InstallerAdapter $adapter): bool
	{
		if ($type === 'install')
		{
			echo '<style>a[target="_blank"]::before {display: none};</style>';
			echo '<div class="mb-3 text-center"><img src="https://www.joomill-extensions.com/images/joomill-logo.png" alt="Joomill Extensions" /></div>';
			echo '<div class="mb-3 text-center"><strong>' . Text::_('PLG_CONTENT_SOCIALSHARE_XML_DESCRIPTION') . '</strong></div>';
			echo '<div class="mb-3 text-center">' . Text::_('PLG_CONTENT_SOCIALSHARE_THANKYOU') . '</div>';
			echo '<br>';
			echo '<h3>' . Text::_('PLG_CONTENT_SOCIALSHARE_INSTALL_QUICKSTART') . ':</h3>';
			echo '<ul>';
			echo '<li><a style="text-decoration: underline;" href="index.php?option=com_plugins&view=plugins&filter[folder]=content&filter[element]=socialshare" target="_blank">' . Text::_('PLG_CONTENT_SOCIALSHARE_INSTALL_CONFIGURATION') . '</a></li>';
			echo '<li><a style="text-decoration: underline;" href="https://www.joomill-extensions.com/documentation/social-share-plugin" target="_blank">' . Text::_('PLG_CONTENT_SOCIALSHARE_INSTALL_NEEDHELP') . '</a></li>';
			echo '</ul>';
			echo '<hr>';
			echo '<div class="text-center">' . Text::_('PLG_CONTENT_SOCIALSHARE_FOLLOWME') . ':</div>';
			echo '<div class="text-center">';
			echo '<a class="m-2" href="https://www.linkedin.com/in/jeroenmoolenschot/" target="_blank"><i class="fa-brands fa-linkedin"> </i></a>';
			echo '<a class="m-2" href="https://www.facebook.com/Joomill" target="_blank"><i class="fa-brands fa-facebook-f"> </i></a>';
			echo '<a class="m-2" href="https://www.instagram.com/Joomill" target="_blank"><i class="fa-brands fa-instagram"> </i></a>';
			echo '<a class="m-2" href="https://bsky.app/profile/joomill.bsky.social" target="_blank"><i class="fa-brands fa-bluesky"> </i></a>';
			echo '<a class="m-2" href="https://joomla.social/@joomill" target="_blank"><i class="fa-brands fa-mastodon"> </i></a>';
			echo '<a class="m-2" href="https://www.threads.net/@joomill" target="_blank"><i class="fa-brands fa-threads"> </i></a>';
			echo '<a class="m-2" href="https://www.twitter.com/Joomill" target="_blank"><i class="fa-brands fa-brands fa-x-twitter"> </i></a>';
			echo '<a class="m-2" href="https://community.joomla.org/service-providers-directory/listings/67:joomill.html" target="_blank"><i class="fa-brands fa-joomla"> </i></a>';
			echo '</div>';
		}

		if ($type === 'uninstall')
		{
			echo '<style>a[target="_blank"]::before {display: none};</style>';
			echo '<div class="mb-3 text-center"><img src="https://www.joomill-extensions.com/images/joomill-logo.png" alt="Joomill Extensions" /></div>';
			echo '<br>';
			echo '<h3 class="text-center">' . Text::_('PLG_CONTENT_SOCIALSHARE_THANKYOU') . '</h3>';
			echo '<br>';
			echo '<div class="text-center">' . Text::_('PLG_CONTENT_SOCIALSHARE_FOLLOWME') . ':</div>';
			echo '<div class="text-center">';
			echo '<a class="m-2" href="https://www.linkedin.com/in/jeroenmoolenschot/" target="_blank"><i class="fa-brands fa-linkedin"> </i></a>';
			echo '<a class="m-2" href="https://www.facebook.com/Joomill" target="_blank"><i class="fa-brands fa-facebook-f"> </i></a>';
			echo '<a class="m-2" href="https://www.instagram.com/Joomill" target="_blank"><i class="fa-brands fa-instagram"> </i></a>';
			echo '<a class="m-2" href="https://bsky.app/profile/joomill.bsky.social" target="_blank"><i class="fa-brands fa-bluesky"> </i></a>';
			echo '<a class="m-2" href="https://joomla.social/@joomill" target="_blank"><i class="fa-brands fa-mastodon"> </i></a>';
			echo '<a class="m-2" href="https://www.threads.net/@joomill" target="_blank"><i class="fa-brands fa-threads"> </i></a>';
			echo '<a class="m-2" href="https://www.twitter.com/Joomill" target="_blank"><i class="fa-brands fa-brands fa-x-twitter"> </i></a>';
			echo '<a class="m-2" href="https://community.joomla.org/service-providers-directory/listings/67:joomill.html" target="_blank"><i class="fa-brands fa-joomla"> </i></a>';
			echo '</div>';
		}

		return true;
	}

	public function install(InstallerAdapter $adapter): bool
	{
		$this->enablePlugin();

		return true;
	}

	public function uninstall(InstallerAdapter $adapter): bool
	{
		return true;
	}

	public function update(InstallerAdapter $adapter): bool
	{
		return true;
	}

	private function enablePlugin(): void
	{
		try
		{
			$db    = Factory::getContainer()->get('DatabaseDriver');
			$query = $db->getQuery(true)
				->update($db->quoteName('#__extensions'))
				->set($db->quoteName('enabled') . ' = ' . $db->quote(1))
				->where('type = ' . $db->quote('plugin'))
				->where('folder = ' . $db->quote('content'))
				->where('element = ' . $db->quote('socialshare'));
			$db->setQuery($query);
			$db->execute();
		}
		catch (\Exception $e)
		{
			return;
		}
	}
}
