<?php
/*
 *  package: Joomill - Social Share
 *  copyright: Copyright (c) 2023. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 2 or later
 *  link: https://www.joomill-extensions.com
 */

defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Image\Image;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Table\Category;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Uri\Uri;

// We require com_content's route helper
JLoader::registerAlias('ContentHelperRoute', '\\Joomla\\Component\\Content\\Site\\Helper\\RouteHelper', '5.0');

class PlgContentsocialshare extends CMSPlugin
{
	protected $app;
	protected $autoloadLanguage = true;
	protected $db;
	private static $hasProcessedCategory = false;

	public function onContentAfterTitle($context, &$article, &$params, $page)
	{
		/*
		 * Validate the plugin should run in the current context
		 */

		// Context check - This only works for com_content
		if (strpos($context, 'com_content') === false)
		{
			return;
		}

		// Additional context check; we only want this for the component!
		if (strpos($this->app->scope, 'mod_') === 0)
		{
			return;
		}

		// Make sure the document is an HTML document
		$document = $this->app->getDocument();

		if ($document->getType() != 'html')
		{
			return;
		}

		/*
		 * Start processing the plugin event
		 */

		// Set the parameters
		$displayPlatformName= $this->params->get('displayPlatformName', '1');
        $prefixPlatformName = $this->params->get('prefixPlatformName', '');
		$displayPlatformIcon= $this->params->get('displayPlatformIcon', '1');
		$displayEmail       = $this->params->get('displayEmail', '1');
		$displayFacebook    = $this->params->get('displayFacebook', '1');
		$displayTwitter     = $this->params->get('displayTwitter', '1');
		$displayLinkedin    = $this->params->get('displayLinkedin', '1');
		$displayPinterest   = $this->params->get('displayPinterest', '1');
		$displayReddit      = $this->params->get('displayReddit', '1');
		$displayTumblr      = $this->params->get('displayTumblr', '1');
		$displayWhatsapp    = $this->params->get('displayWhatsapp', '1');
		$displayTelegram    = $this->params->get('displayTelegram', '1');
		$displayFlipboard   = $this->params->get('displayFlipboard', '1');
		$displayPocket      = $this->params->get('displayPocket', '1');
		$displayTrello      = $this->params->get('displayTrello', '1');
		$selectedCategories = $this->params->def('displayCategories', '');
		$position           = $this->params->def('displayPosition', 'top');
        $target             = $this->params->def('target', '_blank');
		$stickyShare        = $this->params->get('stickyShare', '');
		$view               = $this->app->input->getCmd('view', '');


		// Check whether we're displaying the plugin in the current view
		if ($this->params->get('view' . ucfirst($view), '1') == '0')
		{
			return;
		}

		// If we're not in the article view, we have to get the full $article object ourselves
		if ($view == 'featured' || $view == 'category')
		{
			/*
			 * We only want to handle com_content items; if this function returns null, there's no DB item
			 * Also, make sure the object isn't already loaded and undo previous plugin processing
			 */
			$data = $this->loadArticle($article);

			if ((!is_null($data)) && (!isset($article->catid)))
			{
				$article = $data;
			}
		}

		// Make sure we have a category ID, otherwise, end processing
		$properties = get_object_vars($article);

		if (!array_key_exists('catid', $properties))
		{
			return;
		}

		// Get the current category
		if (is_null($article->catid))
		{
			$currentCategory = 0;
		}
		else
		{
			$currentCategory = $article->catid;
		}

		// Define category restrictions
		if (is_array($selectedCategories))
		{
			$categories = $selectedCategories;
		}
		elseif ($selectedCategories == '')
		{
			$categories = [$currentCategory];
		}
		else
		{
			$categories = [$selectedCategories];
		}

		// If we aren't in a defined category, exit
		if (!in_array($currentCategory, $categories))
		{
			// If we made it this far, we probably deleted the text object; reset it
			if (!isset($article->text))
			{
				$article->text = $article->introtext;
			}

			return;
		}

		// Create the article slug
		$article->slug = $article->alias ? ($article->id . ':' . $article->alias) : $article->id;

		// Build the URL for the plugins to use - the site URL should only be the scheme and host segments, Route will take care of the rest
		$siteURL = Uri::getInstance()->toString(['scheme', 'host', 'port']);
		$itemURL = $siteURL . Route::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));

		// Check that we're actually displaying a button
		if ($displayFacebook == '0'  && $displayTwitter == '0' && $displayLinkedin == '0' && $displayPinterest == '0' && $displayWhatsapp == '0'  && $displayPocket == '0' && $displayEmail == '0' && $displayEmail == '0')
		{
			return;
		}

		// Load the layout
		ob_start();
		$template = PluginHelper::getLayoutPath('content', 'socialshare');
		include $template;
		$output = ob_get_clean();

        if (!property_exists($article, 'introtext')) {
            $article->introtext = $article->text;
        }

        if ($position == 'top') {
            if ($view != 'article') {
                $article->introtext = $output . $article->introtext;
            }
            $article->text = $output . $article->text;
        } elseif ($position == 'bottom') {
            if ($view != 'article') {
                $article->introtext .= $output;
            }
            $article->text .= $output;
        } elseif ($position == 'both') {
            if ($view != 'article') {
                $article->introtext = $output . $article->introtext . $output;
            }
            $article->text = $output . $article->text . $output;
        }

		return;
	}

	/**
	 * Listener for the `onContentPrepare` event
	 *
	 * @param   string   $context   The context of the content being passed to the plugin.
	 * @param   object   &$article  The article object.  Note $article->text is also available
	 * @param   object   &$params   The article params
	 * @param   integer  $page      The 'page' number
	 *
	 * @return  void
	 *
	 * @since   1.1
	 */
	public function onContentPrepare($context, &$article, &$params, $page)
	{
		/*
		 * Validate the plugin should run in the current context
		 */

		// Has the plugin already triggered?
		if (self::$hasProcessedCategory)
		{
			return;
		}

		// Context check - This only works for com_content
		if (strpos($context, 'com_content') === false)
		{
			self::$hasProcessedCategory = true;

			return;
		}

		// Check if the plugin is enabled
		if (PluginHelper::isEnabled('content', 'socialshare') == false)
		{
			self::$hasProcessedCategory = true;

			return;
		}

		// Make sure the document is an HTML document
		$document = $this->app->getDocument();

		if ($document->getType() != 'html')
		{
			self::$hasProcessedCategory = true;

			return;
		}

		/*
		 * Start processing the plugin event
		 */

		// Set the parameters
		$view = $this->app->input->getCmd('view', '');

		// Check whether we're displaying the plugin in the current view
		if ($this->params->get('view' . ucfirst($view), '1') == '0')
		{
			self::$hasProcessedCategory = true;

			return;
		}

		// The featured view is not yet supported and the article view never will be
		if (in_array($view, ['article', 'featured']))
		{
			self::$hasProcessedCategory = true;

			return;
		}

		// Get the requested category
		/** @var Category $category */
		$category = Table::getInstance('Category');
		$category->load($this->app->input->getUint('id'));

		// Build the URL for the plugins to use - the site URL should only be the scheme and host segments, JRoute will take care of the rest
		$siteURL = Uri::getInstance()->toString(['scheme', 'host', 'port']);
		$itemURL = $siteURL . Route::_(ContentHelperRoute::getCategoryRoute($category->id));

		$description = !empty($category->metadesc) ? $category->metadesc : strip_tags($category->description);

		// We're done here
		self::$hasProcessedCategory = true;
	}

	/**
	 * Function to retrieve the full article object
	 *
	 * @param   object  $article  The content object
	 *
	 * @return  object  The full content object
	 *
	 * @since   1.0
	 */
	private function loadArticle($article)
	{
		// Query the database for the article text
		$query = $this->db->getQuery(true)
			->select('*')
			->from($this->db->quoteName('#__content'))
			->where($this->db->quoteName('introtext') . ' = ' . $this->db->quote($article->text));
		$this->db->setQuery($query);

		return $this->db->loadObject();
	}
}
