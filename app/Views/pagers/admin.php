<?php

use CodeIgniter\Pager\PagerRenderer;

/** @var PagerRenderer $pager */
$pager->setSurroundCount($pager->getPageCount());
?>

<nav class="pager-nav" aria-label="Navigasi halaman">
    <div class="pager-summary">
        Halaman <?= esc($pager->getCurrentPageNumber()) ?> dari <?= esc($pager->getPageCount()) ?>
    </div>
    <ul class="pager-list">
        <?php if ($pager->hasPrevious()): ?>
            <li><a class="pager-link pager-arrow" href="<?= $pager->getFirst() ?>" aria-label="Halaman pertama" title="Halaman pertama">&laquo;</a></li>
            <li><a class="pager-link pager-arrow" href="<?= $pager->getPrevious() ?>" aria-label="Halaman sebelumnya" title="Halaman sebelumnya">&lsaquo;</a></li>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="<?= $link['active'] ? 'is-active' : '' ?>">
                <?php if ($link['active']): ?>
                    <span class="pager-link" aria-current="page"><?= esc($link['title']) ?></span>
                <?php else: ?>
                    <a class="pager-link" href="<?= $link['uri'] ?>"><?= esc($link['title']) ?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()): ?>
            <li><a class="pager-link pager-arrow" href="<?= $pager->getNext() ?>" aria-label="Halaman berikutnya" title="Halaman berikutnya">&rsaquo;</a></li>
            <li><a class="pager-link pager-arrow" href="<?= $pager->getLast() ?>" aria-label="Halaman terakhir" title="Halaman terakhir">&raquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>
