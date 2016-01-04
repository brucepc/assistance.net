<div class='pad-bottom'>
	<a href="<?php echo Router::BuildUrl('profile', $vars['request']['creator_uid']); ?>">
		<div class='which-icon <?php if (empty($vars['creator']['picture'])) echo 'fico-person' ?> pull-left space-right' style='background-image: url("<?php echo $vars['creator']['picture'] ?>")'></div>
		<h2 class='iblock theme-color-profile'><?php echo $vars['creator']['name'] ?></h2>
	</a>
	<div style="color: #808080"><?php if ($vars['creator']['max_rating'] == 0) echo 'This user has no rating'; else printf('<strong>%s</strong> / <strong>%s</strong>', $vars['creator']['rating'], $vars['creator']['max_rating']); ?></div>
</div>
<?php echo $vars['cat_count'] . Helpers\Pluralize(' other request', $vars['cat_count']) ?> in this category<br>
<?php echo $vars['purchases'] . ' ' . Helpers\Pluralize(array('person','has'), $vars['purchase']) ?>  purchased this service