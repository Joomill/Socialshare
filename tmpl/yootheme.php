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

    <div class="socialshare-uikit-container uk-padding-small <?php echo ($view == 'article') ? $stickyShare : ''; ?> <?php echo $yoothemeBackground; ?> <?php echo $yoothemeTextColor; ?> <?php echo $yoothemeAlign; ?>">
        <span class="socialshare-uikit-text"><?php echo $yoothemePrefix; ?></span>
        <ul class="socialshare-uikit uk-child-width-auto uk-grid-small uk-flex-inline uk-flex-middle uk-grid">
			<?php foreach ($socialPlatforms as $platform => $data): ?>
				<?php if ($data['enabled']): ?>
                    <li class="el-item">
                        <a href="<?php echo $data['url']; ?>"
                           target="<?php echo $target; ?>"
                           rel="referrer noopener"
                           aria-label="<?php echo Text::_($prefixPlatformName); ?> <?php echo $data['text']; ?> <?php if ($target == "_blank") { ?>, opens a new window<?php } ?>"
                           title="<?php echo Text::_($prefixPlatformName); ?> <?php echo $data['text']; ?>"
                           class="<?php echo $yoothemeStyle; ?>"
                           uk-icon="<?php echo strtolower(str_ireplace('email', 'mail', $data['text'])); ?>">
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

<?php if ($this->params->get('displayPocket', '0')) { ?>
    <script>
        UIkit.icon.add('pocket', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512"><path d="M407.6 64h-367C18.5 64 0 82.5 0 104.6v135.2C0 364.5 99.7 464 224.2 464c124 0 223.8-99.5 223.8-224.2V104.6c0-22.4-17.7-40.6-40.4-40.6zm-162 268.5c-12.4 11.8-31.4 11.1-42.4 0C89.5 223.6 88.3 227.4 88.3 209.3c0-16.9 13.8-30.7 30.7-30.7 17 0 16.1 3.8 105.2 89.3 90.6-86.9 88.6-89.3 105.5-89.3 16.9 0 30.7 13.8 30.7 30.7 0 17.8-2.9 15.7-114.8 123.2z"/></svg>');
    </script>
<?php } ?>

<?php if ($this->params->get('displayTrello', '0')) { ?>
    <script>
        UIkit.icon.add('trello', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512"><path d="M392.3 32H56.1C25.1 32 0 57.1 0 88c-.1 0 0-4 0 336 0 30.9 25.1 56 56 56h336.2c30.8-.2 55.7-25.2 55.7-56V88c.1-30.8-24.8-55.8-55.6-56zM197 371.3c-.2 14.7-12.1 26.6-26.9 26.6H87.4c-14.8.1-26.9-11.8-27-26.6V117.1c0-14.8 12-26.9 26.9-26.9h82.9c14.8 0 26.9 12 26.9 26.9v254.2zm193.1-112c0 14.8-12 26.9-26.9 26.9h-81c-14.8 0-26.9-12-26.9-26.9V117.2c0-14.8 12-26.9 26.8-26.9h81.1c14.8 0 26.9 12 26.9 26.9v142.1z"/></svg>');
    </script>
<?php } ?>