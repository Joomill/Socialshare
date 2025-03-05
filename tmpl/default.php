<?php
/*
 *  package: Joomill - Social Share
 *  copyright: Copyright (c) 2025. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>

<div class="share-container <div class="share-container <?php echo ($view == 'article') ? $stickyShare : ''; ?>">
    <ul class="socialshare-buttons clearfix">
		<?php foreach ($socialPlatforms as $platform => $data): ?>
			<?php if ($data['enabled']): ?>
                <li class="socialshare-<?php echo $platform; ?>">
                    <a href="<?php echo $data['url']; ?>"
                       target="<?php echo $target; ?>"
                       rel="referrer noopener"
                       aria-label="<?php echo Text::_($prefixPlatformName); ?> <?php echo $data['text']; ?> <?php if ($target == "_blank") { ?>, opens a new window<?php } ?>"
                    >
                        <span class="socialshare-icon <?php echo $displayPlatformIcon; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                 viewBox="<?php echo $data['iconViewbox']; ?>">
                                <path d="<?php echo $data['iconPath']; ?>"/>
                            </svg>
                        </span>
                        <span class="socialshare-text <?php echo $displayPlatformName; ?>"><?php echo Text::_($prefixPlatformName); ?><?php echo $data['text']; ?></span>
                    </a>
                </li>
			<?php endif; ?>
		<?php endforeach; ?>
    </ul>
</div>
