<?php
/*
 *  package: Joomill - Social Share
 *  copyright: Copyright (c) 2025. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

// No direct access.
\defined('_JEXEC') or die;

use Joomill\Plugin\Content\Socialshare\Extension\Socialshare;
use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;

return new class () implements ServiceProviderInterface {
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 *
	 * @since   4.3.0
	 */
	public function register(Container $container)
	{
		$container->set(
			PluginInterface::class,
			function (Container $container) {
				$subject = $container->get(DispatcherInterface::class);
				$plugin  = new Socialshare(
					$subject,
					(array) PluginHelper::getPlugin('content', 'socialshare')
				);
				$plugin->setApplication(Factory::getApplication());

				return $plugin;
			}
		);
	}
};
