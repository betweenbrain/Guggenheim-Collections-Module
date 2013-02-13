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
	<?php if (isset($item['media'])) : ?>
		<img src="<?php echo $item['media'] ?>" />
	<?php endif ?>

	<?php if (isset($item['link'])) : ?>
		<a href="<?php echo $item['link'] ?>"><?php echo $item['link'] ?></a>
	<?php endif ?>

	<?php if (isset($item['name'])) : ?>
		<p><?php echo $item['name']['firstname'] . ' ' . $item['name']['middlename'] . ' ' . $item['name']['lastname']?></p>
	<?php endif ?>

	<?php if (isset($item['date'])) : ?>
		<p><?php echo $item['date'] ?></p>
	<?php endif ?>

	<?php if (isset($item['essay'])) : ?>
		<div class="essay"><?php echo $item['essay'] ?></div>
	<?php endif ?>
		</li>
	<?php endforeach ?>
		</ul>
</div>
<?php endif ?>

