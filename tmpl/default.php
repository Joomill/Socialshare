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

<div class="share-container <?php echo htmlspecialchars(($view == 'article') ? $stickyShare : '', ENT_QUOTES, 'UTF-8'); ?>">
<ul class="socialshare-buttons clearfix">
	<?php foreach ($socialPlatforms as $platform => $data): ?>
		<?php if ($data['enabled']): ?>
            <li class="socialshare-<?php echo htmlspecialchars($platform, ENT_QUOTES, 'UTF-8'); ?>">
                <a href="<?php echo htmlspecialchars($data['url'], ENT_QUOTES, 'UTF-8'); ?>"
                   target="<?php echo htmlspecialchars($target, ENT_QUOTES, 'UTF-8'); ?>"
                   rel="referrer noopener"
                   aria-label="<?php echo htmlspecialchars(Text::_($prefixPlatformName) . ' ' . $data['text'] . ($target === '_blank' ? ', opens a new window' : ''), ENT_QUOTES, 'UTF-8'); ?>"
                >
                        <span class="socialshare-icon <?php echo htmlspecialchars($displayPlatformIcon, ENT_QUOTES, 'UTF-8'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                 viewBox="<?php echo $data['iconViewbox']; ?>">
                                <path d="<?php echo $data['iconPath']; ?>"/>
                            </svg>
                        </span>
                    <span class="socialshare-text <?php echo htmlspecialchars($displayPlatformName, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(Text::_($prefixPlatformName), ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($data['text'], ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
            </li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
</div>
