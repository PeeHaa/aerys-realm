<?php declare(strict_types=1); ?>
<pre>You are on <?= $this->render('/blocks/tile', ['tile' => $this->tile]); ?>.
<?php if ($this->northTile->isAccessible()) { ?> To the <?= $this->render('/blocks/direction', ['direction' => 'north']); ?> you see <?= $this->render('/blocks/tile', ['tile' => $this->northTile]); ?>.
<?php } ?>
<?php if ($this->eastTile->isAccessible()) { ?> To the <?= $this->render('/blocks/direction', ['direction' => 'east']); ?> you see <?= $this->render('/blocks/tile', ['tile' => $this->eastTile]); ?>.
<?php } ?>
<?php if ($this->southTile->isAccessible()) { ?> To the <?= $this->render('/blocks/direction', ['direction' => 'south']); ?> you see <?= $this->render('/blocks/tile', ['tile' => $this->southTile]); ?>.
<?php } ?>
<?php if ($this->westTile->isAccessible()) { ?> To the <?= $this->render('/blocks/direction', ['direction' => 'west']); ?> you see <?= $this->render('/blocks/tile', ['tile' => $this->westTile]); ?>.
<?php } ?>
<?php if ($this->npc) { ?>

 <?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> is wandering around here.
<?php } ?></pre>
