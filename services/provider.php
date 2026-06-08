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
use Joomla\Database\DatabaseInterface;
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
	public function register(Container $container): void
	{
		$factory = function (Container $container): PluginInterface {
			$subject = $container->get(DispatcherInterface::class);
			$plugin  = new Socialshare(
				$subject,
				(array) PluginHelper::getPlugin('content', 'socialshare')
			);
			$plugin->setApplication(Factory::getApplication());
			$plugin->setDatabase($container->get(DatabaseInterface::class));

			return $plugin;
		};

		// Lazy plugin loading exists from Joomla 6.1; fall back to a plain
		// factory closure on J5 / 6.0 where Container::lazy() does not exist.
		$container->set(
			PluginInterface::class,
			method_exists($container, 'lazy')
				? $container->lazy(Socialshare::class, $factory)
				: $factory
		);
	}
};
