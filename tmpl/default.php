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
	<div class="sd-strip-controls-container">
		<div class="sd-strip-controls">
			<img class="control sd-forward" src="http://www.guggenheim.org/templates/guggenheim_ubs_map_portal/images/right-arrow.png" alt="Forward" />
			<img class="control sd-back" src="http://www.guggenheim.org/templates/guggenheim_ubs_map_portal/images/left-arrow.png" alt="Back" />
		</div>
		<div class="sd-strip-container">
			<ul class="sd-strip">
				<?php foreach ($items as $item) : ?>
				<li>
					<div class="buffer">

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
					</div>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>
<?php endif ?>

