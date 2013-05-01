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
	<div data-looper="go" id="looper<?php echo $module->id; ?>" data-interval="false" class="looper side slide collections<?php echo $moduleclass_sfx ?>">
		<div class="nav">
			<a data-looper="prev" class="prev" href="#looper<?php echo $module->id; ?>">Previous</a>
			<a data-looper="next" class="next" href="#looper<?php echo $module->id; ?>">Next</a>
		</div>
		<ul class="looper-inner">
			<?php foreach ($items as $i => $item) : ?>
				<?php echo $collection->loopStart($i) ?>
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
				<?php echo $collection->loopEnd($i, $last) ?>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>

