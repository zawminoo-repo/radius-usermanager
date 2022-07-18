<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<div class="w3-bar">
	<?php if($pager->hasPrevious()) : ?>
		<a href="<?= $pager->getFirst(); ?>" class="w3-button">First</a>
		<a href="<?= $pager->getPrevious(); ?>" class="w3-button">«</a>
	<?php endif; ?>
	
	<?php foreach ($pager->links() as $link) : ?>
		<a href="<?= $link['uri'] ?>" class="w3-button <?= $link['active'] ? 'w3-green' : ''; ?>"><?= $link['title'] ?></a>
	<?php endforeach ?>
	
	<?php if($pager->hasNext()) : ?>
		<a href="<?= $pager->getNext(); ?>" class="w3-button">»</a>
		<a href="<?= $pager->getLast(); ?>" class="w3-button">Last</a>
	<?php endif; ?>
</div>
