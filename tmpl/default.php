<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    2/12/13 11:59 AM
 * Author     Matt Thomas
 * Website    http://betweenbrain.com
 * Email      matt@betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2012 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

if ($items) : ?>
<?php foreach ($items as $item) : ?>
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
		<p><?php echo $item['essay'] ?></p>
	<?php endif ?>
	<?php endforeach ?>
<?php endif ?>


