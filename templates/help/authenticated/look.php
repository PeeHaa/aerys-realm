<?php declare(strict_types=1); ?>
<pre>Type <?= $this->render('/blocks/command', ['command' => 'look']); ?> to see your surroundings including walkable pathways.</pre>
<pre>Type <?= $this->render('/blocks/command', ['command' => 'look direction']); ?> to look in a specific direction (<?= $this->render('/blocks/direction', ['direction' => 'north']); ?>, <?= $this->render('/blocks/direction', ['direction' => 'south']); ?>, <?= $this->render('/blocks/direction', ['direction' => 'east']); ?> or <?= $this->render('/blocks/direction', ['direction' => 'west']); ?>).</pre>
