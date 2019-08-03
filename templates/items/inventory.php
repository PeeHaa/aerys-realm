<?php declare(strict_types=1); ?>
<pre class="info">****<?= str_repeat('*', $this->lineLength); ?>****
*   <?= str_repeat(' ', $this->lineLength); ?>   *
<?php if (!count($this->items)) { ?>
*   Your inventory is empty<?= str_repeat(' ', $this->lineLength - 20); ?>*
<?php } else { ?>
<?php foreach ($this->items as $item) { ?>
*   <?= $this->escape($item->getName()); ?> - <?= $this->escape($item->getDescription()); ?><?= str_repeat(' ', $this->lineLength - mb_strlen($item->getName()) - mb_strlen($item->getDescription())); ?>*
<?php } ?>
<?php } ?>
*   <?= str_repeat(' ', $this->lineLength); ?>   *
****<?= str_repeat('*', $this->lineLength); ?>****</pre>
