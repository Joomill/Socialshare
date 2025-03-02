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
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;

class plgContentsocialshareInstallerScript
{
	/**
	 * Minimum Joomla version to check
	 *
	 * @var    string
	 * @since  4.0.0
	 */
	private $minimumJoomlaVersion = '4.0';

	/**
	 * Minimum PHP version to check
	 *
	 * @var    string
	 * @since  4.0.0
	 */
	private $minimumPHPVersion = JOOMLA_MINIMUM_PHP;

	/**
	 * Function called before extension installation/update/removal procedure commences
	 *
	 * @param   string            $type    The type of change (install, update or discover_install, not uninstall)
	 * @param   InstallerAdapter  $parent  The class calling this method
	 *
	 * @return  boolean  True on success
	 * @throws Exception
	 * @since  4.0.0
	 */
	public function preflight($type, $parent): bool
	{
		if ($type !== 'uninstall')
		{
			// Check for the minimum PHP version before continuing
			if (!empty($this->minimumPHPVersion) && version_compare(PHP_VERSION, $this->minimumPHPVersion, '<'))
			{
				Log::add(
					Text::sprintf('JLIB_INSTALLER_MINIMUM_PHP', $this->minimumPHPVersion),
					Log::WARNING,
					'jerror'
				);

				return false;
			}
			// Check for the minimum Joomla version before continuing
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

	/**
	 * Function called after extension installation/update/removal procedure commences
	 *
	 * @param   string            $type    The type of change (install, update or discover_install, not uninstall)
	 * @param   InstallerAdapter  $parent  The class calling this method
	 *
	 * @return  boolean  True on success
	 * @since  4.0.0
	 */
	public function postflight($type, $parent)
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
			echo '<a class="m-2" href="https://joomla.social/@joomill" target="_blank"><i class="fa-brands fa-mastodon"></i> </i></a>';
			echo '<a class="m-2" href="https://www.threads.net/@joomill" target="_blank"><i class="fa-brands fa-threads"></i> </i></a>';
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
			echo '<a class="m-2" href="https://joomla.social/@joomill" target="_blank"><i class="fa-brands fa-mastodon"></i> </i></a>';
			echo '<a class="m-2" href="https://www.threads.net/@joomill" target="_blank"><i class="fa-brands fa-threads"></i> </i></a>';
			echo '<a class="m-2" href="https://www.twitter.com/Joomill" target="_blank"><i class="fa-brands fa-brands fa-x-twitter"> </i></a>';
			echo '<a class="m-2" href="https://community.joomla.org/service-providers-directory/listings/67:joomill.html" target="_blank"><i class="fa-brands fa-joomla"> </i></a>';
			echo '</div>';
		}

		return true;
	}

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