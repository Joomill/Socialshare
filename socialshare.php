<?php
/*
 *  package: Joomill - Social Share
 *  copyright: Copyright (c) 2025. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
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

// Import media
HTMLHelper::_('stylesheet', 'plg_content_socialshare/socialshare.css', ['version' => 'auto', 'relative' => true]);

class PlgContentsocialshare extends CMSPlugin
{
	private static $hasProcessedCategory = false;
	protected $app;
	protected $autoloadLanguage = true;
	protected $db;

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

		// Check if device is mobile
		$isMobile = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));

		// Set the parameters
		$displayPlatformName = $this->params->get('displayPlatformName', '1');
		$prefixPlatformName  = $this->params->get('prefixPlatformName', '');
		$displayPlatformIcon = $this->params->get('displayPlatformIcon', '1');
		$selectedCategories  = $this->params->def('displayCategories', '');
		$position            = $this->params->def('displayPosition', 'top');
		$target              = $this->params->def('target', '_blank');
		$stickyShare         = $this->params->get('stickyShare', '');
		$view                = $this->app->input->getCmd('view', '');

		$yoothemeBackground = $this->params->get('yoothemeBackground', '');
		$yoothemeTextColor  = $this->params->get('yoothemeTextColor', '');
		$yoothemeStyle      = $this->params->get('yoothemeStyle', 'uk-icon');
		$yoothemeAlign      = $this->params->get('yoothemeAlign', 'left');
		$yoothemePrefix     = $this->params->get('yoothemePrefix', '');

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


		$socialPlatforms = [
			'facebook' => [
				'enabled'     => $this->params->get('displayFacebook', '1'),
				'url'         => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($itemURL),
				'iconPath'    => "M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z",
				'iconViewbox' => "0 0 320 512",
				'text'        => "Facebook",
				'order'       => 1,
			],

			'twitter' => [
				'enabled'     => $this->params->get('displayTwitter', '1'),
				'url'         => "https://twitter.com/intent/tweet?text=" . urlencode($article->title . ': ' . $itemURL),
				'iconPath'    => "M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z",
				'iconViewbox' => "0 0 512 512",
				'text'        => "X",
				'order'       => 2,
			],

			'linkedin' => [
				'enabled'     => $this->params->get('displayLinkedin', '1'),
				'url'         => "http://www.linkedin.com/shareArticle?url=" . urlencode($itemURL) . "&title=" . urlencode($article->title) . "&summary=" . urlencode(HTMLHelper::_('string.truncate', $article->text, 50, false, false)),
				'iconPath'    => "M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 1 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z",
				'iconViewbox' => "0 0 448 512",
				'text'        => "LinkedIn",
				'order'       => 3,
			],

			'threads' => [
				'enabled'     => $this->params->get('displayThreads', '0'),
				'url'         => "https://www.threads.net/intent/post?text=" . urlencode($article->title . ' ' . $itemURL),
				'iconPath'    => "M331.5 235.7c2.2 .9 4.2 1.9 6.3 2.8c29.2 14.1 50.6 35.2 61.8 61.4c15.7 36.5 17.2 95.8-30.3 143.2c-36.2 36.2-80.3 52.5-142.6 53h-.3c-70.2-.5-124.1-24.1-160.4-70.2c-32.3-41-48.9-98.1-49.5-169.6V256v-.2C17 184.3 33.6 127.2 65.9 86.2C102.2 40.1 156.2 16.5 226.4 16h.3c70.3 .5 124.9 24 162.3 69.9c18.4 22.7 32 50 40.6 81.7l-40.4 10.8c-7.1-25.8-17.8-47.8-32.2-65.4c-29.2-35.8-73-54.2-130.5-54.6c-57 .5-100.1 18.8-128.2 54.4C72.1 146.1 58.5 194.3 58 256c.5 61.7 14.1 109.9 40.3 143.3c28 35.6 71.2 53.9 128.2 54.4c51.4-.4 85.4-12.6 113.7-40.9c32.3-32.2 31.7-71.8 21.4-95.9c-6.1-14.2-17.1-26-31.9-34.9c-3.7 26.9-11.8 48.3-24.7 64.8c-17.1 21.8-41.4 33.6-72.7 35.3c-23.6 1.3-46.3-4.4-63.9-16c-20.8-13.8-33-34.8-34.3-59.3c-2.5-48.3 35.7-83 95.2-86.4c21.1-1.2 40.9-.3 59.2 2.8c-2.4-14.8-7.3-26.6-14.6-35.2c-10-11.7-25.6-17.7-46.2-17.8H227c-16.6 0-39 4.6-53.3 26.3l-34.4-23.6c19.2-29.1 50.3-45.1 87.8-45.1h.8c62.6 .4 99.9 39.5 103.7 107.7l-.2 .2zm-156 68.8c1.3 25.1 28.4 36.8 54.6 35.3c25.6-1.4 54.6-11.4 59.5-73.2c-13.2-2.9-27.8-4.4-43.4-4.4c-4.8 0-9.6 .1-14.4 .4c-42.9 2.4-57.2 23.2-56.2 41.8l-.1 .1z",
				'iconViewbox' => "0 0 448 512",
				'text'        => "Threads",
				'order'       => 4,
			],

			'mastodon' => [
				'enabled'     => $this->params->get('displayMastodon', '0'),
				'url'         => "https://mastodonshare.com/?url=" . urlencode($itemURL) . "&text=" . urlencode($article->title),
				'iconPath'    => "M433 179.1c0-97.2-63.7-125.7-63.7-125.7-62.5-28.7-228.6-28.4-290.5 0 0 0-63.7 28.5-63.7 125.7 0 115.7-6.6 259.4 105.6 289.1 40.5 10.7 75.3 13 103.3 11.4 50.8-2.8 79.3-18.1 79.3-18.1l-1.7-36.9s-36.3 11.4-77.1 10.1c-40.4-1.4-83-4.4-89.6-54a102.5 102.5 0 0 1 -.9-13.9c85.6 20.9 158.7 9.1 178.8 6.7 56.1-6.7 105-41.3 111.2-72.9 9.8-49.8 9-121.5 9-121.5zm-75.1 125.2h-46.6v-114.2c0-49.7-64-51.6-64 6.9v62.5h-46.3V197c0-58.5-64-56.6-64-6.9v114.2H90.2c0-122.1-5.2-147.9 18.4-175 25.9-28.9 79.8-30.8 103.8 6.1l11.6 19.5 11.6-19.5c24.1-37.1 78.1-34.8 103.8-6.1 23.7 27.3 18.4 53 18.4 175z",
				'iconViewbox' => "0 0 448 512",
				'text'        => "Mastodon",
				'order'       => 5,
			],

			'bluesky' => [
				'enabled'     => $this->params->get('displayBluesky', '1'),
				'url'         => "https://bsky.app/intent/compose?text=" . urlencode($article->title) . " %0A" . urlencode($itemURL),
				'iconPath'    => "M9.993,9.149c-.772-1.495-2.865-4.288-4.813-5.662-1.866-1.317-2.58-1.09-3.043-.878-.54.246-.637,1.075-.637,1.563s.265,4.003.444,4.587c.579,1.939,2.628,2.595,4.519,2.382.096-.014.193-.029.294-.039-.096.014-.198.029-.294.039-2.768.41-5.233,1.418-2.001,5.011,3.55,3.675,4.866-.786,5.541-3.053.675,2.262,1.452,6.564,5.474,3.053,3.024-3.053.83-4.601-1.939-5.011-.096-.01-.198-.024-.294-.039.101.014.198.024.294.039,1.89.212,3.945-.444,4.519-2.382.174-.588.444-4.099.444-4.587s-.096-1.317-.637-1.563c-.468-.212-1.177-.439-3.043.878-1.963,1.379-4.056,4.167-4.827,5.662h0Z",
				'iconViewbox' => "0 0 20 20",
				'text'        => "Bluesky",
				'order'       => 6,
			],

			'pinterest' => [
				'enabled'     => $this->params->get('displayPinterest', '0'),
				'url'         => "http://pinterest.com/pin/create/button/?url=" . urlencode($itemURL) . "&description=" . urlencode($article->title),
				'iconPath'    => "M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z",
				'iconViewbox' => "0 0 384 512",
				'text'        => "Pinterest",
				'order'       => 7,
			],

			'reddit' => [
				'enabled'     => $this->params->get('displayReddit', '0'),
				'url'         => "https://www.reddit.com/submit?url=" . urlencode($itemURL) . "&title=" . urlencode($article->title),
				'iconPath'    => "M440.3 203.5c-15 0-28.2 6.2-37.9 15.9-35.7-24.7-83.8-40.6-137.1-42.3L293 52.3l88.2 19.8c0 21.6 17.6 39.2 39.2 39.2 22 0 39.7-18.1 39.7-39.7s-17.6-39.7-39.7-39.7c-15.4 0-28.7 9.3-35.3 22l-97.4-21.6c-4.9-1.3-9.7 2.2-11 7.1L246.3 177c-52.9 2.2-100.5 18.1-136.3 42.8-9.7-10.1-23.4-16.3-38.4-16.3-55.6 0-73.8 74.6-22.9 100.1-1.8 7.9-2.6 16.3-2.6 24.7 0 83.8 94.4 151.7 210.3 151.7 116.4 0 210.8-67.9 210.8-151.7 0-8.4-.9-17.2-3.1-25.1 49.9-25.6 31.5-99.7-23.8-99.7zM129.4 308.9c0-22 17.6-39.7 39.7-39.7 21.6 0 39.2 17.6 39.2 39.7 0 21.6-17.6 39.2-39.2 39.2-22 .1-39.7-17.6-39.7-39.2zm214.3 93.5c-36.4 36.4-139.1 36.4-175.5 0-4-3.5-4-9.7 0-13.7 3.5-3.5 9.7-3.5 13.2 0 27.8 28.5 120 29 149 0 3.5-3.5 9.7-3.5 13.2 0 4.1 4 4.1 10.2.1 13.7zm-.8-54.2c-21.6 0-39.2-17.6-39.2-39.2 0-22 17.6-39.7 39.2-39.7 22 0 39.7 17.6 39.7 39.7-.1 21.5-17.7 39.2-39.7 39.2z",
				'iconViewbox' => "0 0 512 512",
				'text'        => "Reddit",
				'order'       => 8,
			],

			'tumblr' => [
				'enabled'     => $this->params->get('displayTumblr', '0'),
				'url'         => "https://www.tumblr.com/widgets/share/tool?canonicalUrl=" . urlencode($itemURL) . "&title=" . urlencode($article->title),
				'iconPath'    => "M309.8 480.3c-13.6 14.5-50 31.7-97.4 31.7-120.8 0-147-88.8-147-140.6v-144H17.9c-5.5 0-10-4.5-10-10v-68c0-7.2 4.5-13.6 11.3-16 62-21.8 81.5-76 84.3-117.1.8-11 6.5-16.3 16.1-16.3h70.9c5.5 0 10 4.5 10 10v115.2h83c5.5 0 10 4.4 10 9.9v81.7c0 5.5-4.5 10-10 10h-83.4V360c0 34.2 23.7 53.6 68 35.8 4.8-1.9 9-3.2 12.7-2.2 3.5.9 5.8 3.4 7.4 7.9l22 64.3c1.8 5 3.3 10.6-.4 14.5z",
				'iconViewbox' => "0 0 320 512",
				'text'        => "Tumblr",
				'order'       => 9,
			],

			'whatsapp' => [
				'enabled'     => $this->params->get('displayWhatsapp', '0'),
				'url'         => $isMobile ? "whatsapp://send?text=" . urlencode($article->title . ' ' . $itemURL) : "https://web.whatsapp.com/send?text=" . urlencode($article->title . ' ' . $itemURL),
				'iconPath'    => "M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z",
				'iconViewbox' => "0 0 448 512",
				'text'        => "WhatsApp",
				'order'       => 10,
			],

			'telegram' => [
				'enabled'     => $this->params->get('displayTelegram', '0'),
				'url'         => "https://telegram.me/share/url?url=" . urlencode($itemURL) . "&text=" . urlencode($article->title),
				'iconPath'    => "M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z",
				'iconViewbox' => "0 0 496 512",
				'text'        => "Telegram",
				'order'       => 11,
			],

			'flipboard' => [
				'enabled'     => $this->params->get('displayFlipboard', '0'),
				'url'         => "https://share.flipboard.com/bookmarklet/popout?v=2&url=" . urlencode($itemURL) . "&title=" . urlencode($article->title),
				'iconPath'    => "M0 32v448h448V32H0zm358.4 179.2h-89.6v89.6h-89.6v89.6H89.6V121.6h268.8v89.6z",
				'iconViewbox' => "0 0 448 512",
				'text'        => "Flipboard",
				'order'       => 12,
			],

			'pocket' => [
				'enabled'     => $this->params->get('displayPocket', '0'),
				'url'         => "https://getpocket.com/save?url=" . urlencode($itemURL),
				'iconPath'    => "M407.6 64h-367C18.5 64 0 82.5 0 104.6v135.2C0 364.5 99.7 464 224.2 464c124 0 223.8-99.5 223.8-224.2V104.6c0-22.4-17.7-40.6-40.4-40.6zm-162 268.5c-12.4 11.8-31.4 11.1-42.4 0C89.5 223.6 88.3 227.4 88.3 209.3c0-16.9 13.8-30.7 30.7-30.7 17 0 16.1 3.8 105.2 89.3 90.6-86.9 88.6-89.3 105.5-89.3 16.9 0 30.7 13.8 30.7 30.7 0 17.8-2.9 15.7-114.8 123.2z",
				'iconViewbox' => "0 0 448 512",
				'text'        => "Pocket",
				'order'       => 13,
			],

			'trello' => [
				'enabled'     => $this->params->get('displayTrello', '0'),
				'url'         => "https://trello.com/add-card?url=" . urlencode($itemURL) . "&name=" . urlencode($article->title),
				'iconPath'    => "M392.3 32H56.1C25.1 32 0 57.1 0 88c-.1 0 0-4 0 336 0 30.9 25.1 56 56 56h336.2c30.8-.2 55.7-25.2 55.7-56V88c.1-30.8-24.8-55.8-55.6-56zM197 371.3c-.2 14.7-12.1 26.6-26.9 26.6H87.4c-14.8.1-26.9-11.8-27-26.6V117.1c0-14.8 12-26.9 26.9-26.9h82.9c14.8 0 26.9 12 26.9 26.9v254.2zm193.1-112c0 14.8-12 26.9-26.9 26.9h-81c-14.8 0-26.9-12-26.9-26.9V117.2c0-14.8 12-26.9 26.8-26.9h81.1c14.8 0 26.9 12 26.9 26.9v142.1z",
				'iconViewbox' => "0 0 448 512",
				'text'        => "Trello",
				'order'       => 14,
			],

			'email' => [
				'enabled'     => $this->params->get('displayEmail', '0'),
				'url'         => "mailto:?subject=" . urlencode($article->title) . "&body=" . urlencode($itemURL),
				'iconPath'    => "M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z",
				'iconViewbox' => "0 0 512 512",
				'text'        => "Email",
				'order'       => 15,
			],
		];


		uasort($socialPlatforms, function ($a, $b) {
			return $a['order'] <=> $b['order'];
		});

		// Load the layout
		ob_start();
		$template = PluginHelper::getLayoutPath('content', 'socialshare', $this->params->get('layout', 'default'));
		include $template;
		$output = ob_get_clean();

		if (!property_exists($article, 'introtext'))
		{
			$article->introtext = $article->text;
		}

		if (!property_exists($article, 'fulltext'))
		{
			$article->fulltext = $article->text;
		}

		if ($position == 'top')
		{
			if ($view != 'article')
			{
				$article->introtext = $output . $article->introtext;
			}
			$article->text     = $output . $article->text;
			$article->fulltext = $output . $article->fulltext;
		}
		elseif ($position == 'bottom')
		{
			if ($view != 'article')
			{
				$article->introtext .= $output;
			}
			$article->text     .= $output;
			$article->fulltext .= $output;
		}
		elseif ($position == 'both')
		{
			if ($view != 'article')
			{
				$article->introtext = $output . $article->introtext . $output;
			}
			$article->text     = $output . $article->text . $output;
			$article->fulltext = $output . $article->fulltext . $output;
		}

		return;
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

	/**
	 * Listener for the `onContentPrepare` event
	 *
	 * @param   string    $context  The context of the content being passed to the plugin.
	 * @param   object   &$article  The article object.  Note $article->text is also available
	 * @param   object   &$params   The article params
	 * @param   integer   $page     The 'page' number
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
}
