<?php
/*
 *  package: Joomill - Social Share
 *  copyright: Copyright (c) 2023. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 2 or later
 *  link: https://www.joomill-extensions.com
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

/** @var PlgContentsocialshare $this */

// Import media
HTMLHelper::_('stylesheet', 'plg_content_socialshare/socialshare.css', ['version' => 'auto', 'relative' => true]);

// Check if device is mobile
$isMobile = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
?>

<div class="share-container <?php echo $stickyShare; ?>">
	<ul class="socialshare-buttons clearfix">
		<?php if ($displayFacebook) : ?>
			<li class="socialshare-facebook">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($itemURL); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                            <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
                        </svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Facebook</span>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($displayTwitter) : ?>
			<li class="socialshare-twitter">
				<a href="https://x.com/intent/tweet?text=<?php echo urlencode($article->title . ': ' . $itemURL); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> X</span>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($displayLinkedin) : ?>
			<li class="socialshare-linkedin">
				<a href="http://www.linkedin.com/shareArticle?=<?php echo urlencode($itemURL); ?>&amp;title=<?php echo urlencode($article->title); ?>&amp;summary=<?php echo urlencode(HTMLHelper::_('string.truncate', $article->text, 50, false, false)); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/>
                        </svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Linkedin</span>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($displayPinterest) : ?>
			<li class="socialshare-pinterest">
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($itemURL); ?>&amp;description=<?php echo urlencode($article->title); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                            <path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"/>
                        </svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Pinterest</span>
				</a>
			</li>
		<?php endif; ?>

        <?php if ($displayReddit) : ?>
            <li class="socialshare-reddit">
                <a href="https://www.reddit.com/submit?url=<?php echo urlencode($itemURL); ?>&amp;title=<?php echo urlencode($article->title); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path d="M440.3 203.5c-15 0-28.2 6.2-37.9 15.9-35.7-24.7-83.8-40.6-137.1-42.3L293 52.3l88.2 19.8c0 21.6 17.6 39.2 39.2 39.2 22 0 39.7-18.1 39.7-39.7s-17.6-39.7-39.7-39.7c-15.4 0-28.7 9.3-35.3 22l-97.4-21.6c-4.9-1.3-9.7 2.2-11 7.1L246.3 177c-52.9 2.2-100.5 18.1-136.3 42.8-9.7-10.1-23.4-16.3-38.4-16.3-55.6 0-73.8 74.6-22.9 100.1-1.8 7.9-2.6 16.3-2.6 24.7 0 83.8 94.4 151.7 210.3 151.7 116.4 0 210.8-67.9 210.8-151.7 0-8.4-.9-17.2-3.1-25.1 49.9-25.6 31.5-99.7-23.8-99.7zM129.4 308.9c0-22 17.6-39.7 39.7-39.7 21.6 0 39.2 17.6 39.2 39.7 0 21.6-17.6 39.2-39.2 39.2-22 .1-39.7-17.6-39.7-39.2zm214.3 93.5c-36.4 36.4-139.1 36.4-175.5 0-4-3.5-4-9.7 0-13.7 3.5-3.5 9.7-3.5 13.2 0 27.8 28.5 120 29 149 0 3.5-3.5 9.7-3.5 13.2 0 4.1 4 4.1 10.2.1 13.7zm-.8-54.2c-21.6 0-39.2-17.6-39.2-39.2 0-22 17.6-39.7 39.2-39.7 22 0 39.7 17.6 39.7 39.7-.1 21.5-17.7 39.2-39.7 39.2z"/>
                        </svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Reddit</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($displayTumblr) : ?>
            <li class="socialshare-tumblr">
                <a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo urlencode($itemURL); ?>&title=<?php echo urlencode($article->title); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                            <path d="M309.8 480.3c-13.6 14.5-50 31.7-97.4 31.7-120.8 0-147-88.8-147-140.6v-144H17.9c-5.5 0-10-4.5-10-10v-68c0-7.2 4.5-13.6 11.3-16 62-21.8 81.5-76 84.3-117.1.8-11 6.5-16.3 16.1-16.3h70.9c5.5 0 10 4.5 10 10v115.2h83c5.5 0 10 4.4 10 9.9v81.7c0 5.5-4.5 10-10 10h-83.4V360c0 34.2 23.7 53.6 68 35.8 4.8-1.9 9-3.2 12.7-2.2 3.5.9 5.8 3.4 7.4 7.9l22 64.3c1.8 5 3.3 10.6-.4 14.5z"/>
                        </svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Tumblr</span>
                </a>
            </li>
        <?php endif; ?>

		<?php if ($displayWhatsapp) : ?>
        <li class="socialshare-whatsapp">
            <?php if ($isMobile) { ?>
                <a href="whatsapp://send?text=<?php echo urlencode($article->title); ?> <?php echo urlencode($itemURL); ?>" data-action="share/whatsapp/share" target="<?php echo $target; ?>">
            <?php } else { ?>
                <a href="https://web.whatsapp.com/?text=<?php echo urlencode($article->title); ?> <?php echo urlencode($itemURL); ?>" data-action="share/whatsapp/share" target="<?php echo $target; ?>">
            <?php } ?>
                <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                    </svg>
                </span>
                <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Whatsapp</span>
            </a>
        </li>
		<?php endif; ?>

		<?php if ($displayTelegram) : ?>
            <li class="socialshare-telegram">
                <a href="https://telegram.me/share/url?url=<?php echo urlencode($itemURL); ?>&amp;text=<?php echo urlencode($article->title); ?> " target="<?php echo $target; ?>">
                   <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                       <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 496 512">
                            <path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/>
                        </svg>
                   </span>
                   <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Telegram</span>
                </a>
            </li>
		<?php endif; ?>

        <?php if ($displayFlipboard) : ?>
            <li class="socialshare-flipboard">
                <a href="https://share.flipboard.com/bookmarklet/popout?v=2&?url=<?php echo urlencode($itemURL); ?>&amp;title=<?php echo urlencode($article->title); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                          <path d="M0 32v448h448V32H0zm358.4 179.2h-89.6v89.6h-89.6v89.6H89.6V121.6h268.8v89.6z"/>
                        </svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Flipboard</span>
                </a>
            </li>
        <?php endif; ?>

		<?php if ($displayPocket) : ?>
        <li class="socialshare-pocket">
            <a href="https://getpocket.com/save?url=<?php echo urlencode($itemURL); ?>" target="<?php echo $target; ?>">
                <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                        <path d="M407.6 64h-367C18.5 64 0 82.5 0 104.6v135.2C0 364.5 99.7 464 224.2 464c124 0 223.8-99.5 223.8-224.2V104.6c0-22.4-17.7-40.6-40.4-40.6zm-162 268.5c-12.4 11.8-31.4 11.1-42.4 0C89.5 223.6 88.3 227.4 88.3 209.3c0-16.9 13.8-30.7 30.7-30.7 17 0 16.1 3.8 105.2 89.3 90.6-86.9 88.6-89.3 105.5-89.3 16.9 0 30.7 13.8 30.7 30.7 0 17.8-2.9 15.7-114.8 123.2z"/>
                    </svg>
                </span>
                <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Pocket</span>
            </a>
        </li>
		<?php endif; ?>

        <?php if ($displayTrello) : ?>
            <li class="socialshare-trello">
                <a href="https://trello.com/add-card?url=<?php echo urlencode($itemURL); ?>&amp;name=<?php echo urlencode($article->title); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                            <path d="M392.3 32H56.1C25.1 32 0 57.1 0 88c-.1 0 0-4 0 336 0 30.9 25.1 56 56 56h336.2c30.8-.2 55.7-25.2 55.7-56V88c.1-30.8-24.8-55.8-55.6-56zM197 371.3c-.2 14.7-12.1 26.6-26.9 26.6H87.4c-14.8.1-26.9-11.8-27-26.6V117.1c0-14.8 12-26.9 26.9-26.9h82.9c14.8 0 26.9 12 26.9 26.9v254.2zm193.1-112c0 14.8-12 26.9-26.9 26.9h-81c-14.8 0-26.9-12-26.9-26.9V117.2c0-14.8 12-26.9 26.8-26.9h81.1c14.8 0 26.9 12 26.9 26.9v142.1z"/>
                        </svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Trello</span>
                </a>
            </li>
        <?php endif; ?>

		<?php if ($displayEmail) : ?>
			<li class="socialshare-email">
				<a href="mailto:?subject=<?php echo urlencode($article->title); ?>&amp;body=<?php echo urlencode($itemURL); ?>" target="<?php echo $target; ?>">
                    <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path d="M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z"/>
                        </svg>
                    </span>
                    <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?> Email</span>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>
