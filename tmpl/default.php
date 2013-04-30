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

if ($items) :
	// Load looper.js and Looper.css
	$doc = JFactory::getDocument();
	$app = JFactory::getApplication();
	$doc->addScript('templates/' . $app->getTemplate() . '/js/looper.js');
	$doc->addStylesheet('templates/' . $app->getTemplate() . '/css/looper.css');

	?>
<div data-looper="go" data-interval="false" class="looper slide collections<?php echo $moduleclass_sfx ?>">

	<nav>
			<a data-looper="prev" class="nav prev" href="#k2ModuleBox<?php echo $module->id; ?>">
				Previous
			</a>
			<a data-looper="next" class="nav next" href="#k2ModuleBox<?php echo $module->id; ?>">
				Next
			</a>
		</nav>





		<div class="sd-strip-container">
			<ul class="sd-strip">
				<?php foreach ($items as $item) : ?>
				<li>

					<?php if (isset($item['link'])) : ?>
						<a href="<?php echo $item['link'] ?>">
						<?php endif ?>

					<?php if (isset($item['media'])) : ?>
					<img src="<?php echo $item['media'] ?>" width="<?php echo $item['width'] ?>" height="<?php echo $item['height'] ?>">
					<?php endif ?>

					<?php if (isset($item['link'])) : ?>
						</a>
						<?php endif ?>

					<div class="content">
						<p class="primary"><?php echo $item['title'] ?></p>

						<?php if (isset($item['name'])) : ?>
						<p>
							<?php if (isset($item['bioUrl'])) : ?>
								<a href="<?php echo $item['bioUrl'] ?>">
								<? endif ?>

							<?php echo $item['name'] ?>

							<?php if (isset($item['bioUrl'])) : ?>
								</a>
								<? endif ?>
						</p>
						<?php endif ?>

						<?php if (isset($item['date'])) : ?>
						<p class="when"><?php echo $item['date'] ?></p>
						<?php endif ?>

						<?php if (isset($item['link'])) : ?>
						<a class="more small" href="<?php echo $item['link'] ?>">More</a>
						<?php endif ?>
					</div>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>
<?php endif ?>

