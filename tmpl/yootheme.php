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

    <div class="socialshare-uikit-container uk-padding-small <?php echo htmlspecialchars(($view == 'article') ? $stickyShare : '', ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars($yoothemeBackground, ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars($yoothemeTextColor, ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars($yoothemeAlign, ENT_QUOTES, 'UTF-8'); ?>">
        <span class="socialshare-uikit-text"><?php echo htmlspecialchars(Text::_($yoothemePrefix), ENT_QUOTES, 'UTF-8'); ?></span>
        <ul class="socialshare-uikit uk-child-width-auto uk-grid-small uk-flex-inline uk-flex-middle uk-grid">
			<?php foreach ($socialPlatforms as $platform => $data): ?>
				<?php if ($data['enabled']): ?>
                    <li class="el-item">
                        <a href="<?php echo htmlspecialchars($data['url'], ENT_QUOTES, 'UTF-8'); ?>"
                           target="<?php echo htmlspecialchars($target, ENT_QUOTES, 'UTF-8'); ?>"
                           rel="referrer noopener"
                           aria-label="<?php echo htmlspecialchars(Text::_($prefixPlatformName) . ' ' . $data['text'] . ($target === '_blank' ? ', opens a new window' : ''), ENT_QUOTES, 'UTF-8'); ?>"
                           title="<?php echo htmlspecialchars(Text::_($prefixPlatformName) . ' ' . $data['text'], ENT_QUOTES, 'UTF-8'); ?>"
                           class="<?php echo htmlspecialchars($yoothemeStyle, ENT_QUOTES, 'UTF-8'); ?>"
                           uk-icon="<?php echo htmlspecialchars(strtolower(str_ireplace('email', 'mail', $data['text'])), ENT_QUOTES, 'UTF-8'); ?>">
                        </a>
                    </li>
				<?php endif; ?>
			<?php endforeach; ?>
        </ul>
    </div>

<?php if ($this->params->get('displayFlipboard', '0')) { ?>
    <script>
        UIkit.icon.add('flipboard', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512"><path d="M0 32v448h448V32H0zm358.4 179.2h-89.6v89.6h-89.6v89.6H89.6V121.6h268.8v89.6z"/></svg>');
    </script>
<?php } ?>

<?php if ($this->params->get('displayTrello', '0')) { ?>
    <script>
        UIkit.icon.add('trello', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512"><path d="M392.3 32H56.1C25.1 32 0 57.1 0 88c-.1 0 0-4 0 336 0 30.9 25.1 56 56 56h336.2c30.8-.2 55.7-25.2 55.7-56V88c.1-30.8-24.8-55.8-55.6-56zM197 371.3c-.2 14.7-12.1 26.6-26.9 26.6H87.4c-14.8.1-26.9-11.8-27-26.6V117.1c0-14.8 12-26.9 26.9-26.9h82.9c14.8 0 26.9 12 26.9 26.9v254.2zm193.1-112c0 14.8-12 26.9-26.9 26.9h-81c-14.8 0-26.9-12-26.9-26.9V117.2c0-14.8 12-26.9 26.8-26.9h81.1c14.8 0 26.9 12 26.9 26.9v142.1z"/></svg>');
    </script>
<?php } ?>
