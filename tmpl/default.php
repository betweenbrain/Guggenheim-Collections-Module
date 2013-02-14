<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    12/31/12 11:59 AM
 * Author     Matt Thomas
 * Website    http://betweenbrain.com
 * Email      matt@betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2012 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

if ($items) : ?>
<div class="collections<?php echo $moduleclass_sfx ?>">
	<ul>
		<?php foreach ($items as $item) : ?>
		<li>

			<?php if (isset($item['link'])) : ?>
			<a href="<?php echo $item['link'] ?>">
			<?php endif ?>

			<?php if (isset($item['media'])) : ?>
			<img src="<?php echo $item['media'] ?>" />
			<?php endif ?>

			<?php if (isset($item['link'])) : ?>
			</a>
			<?php endif ?>

			<div class="content">
				<?php echo $item['title'] ?>

				<?php if (isset($item['name'])) : ?>
				<a href="<?php echo $item['bioUrl'] ?>"><?php echo $item['name'] ?></a>
				<?php endif ?>

				<?php if (isset($item['date'])) : ?>
				<p class="date"><?php echo $item['date'] ?></p>
				<?php endif ?>

				<?php if (isset($item['link'])) : ?>
				<a class="more" href="<?php echo $item['link'] ?>">More</a>
				<?php endif ?>
			</div>

		</li>
		<?php endforeach ?>
	</ul>
</div>
<?php endif ?>

