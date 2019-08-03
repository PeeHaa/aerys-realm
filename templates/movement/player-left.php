<?php declare(strict_types=1); ?>
<pre><?= $this->render('/blocks/player', ['player' => $this->player]); ?> left the scene<?php if ($this->direction !== null) { ?> to the <?= $this->render('/blocks/direction', ['direction' => $this->direction]); ?><?php } ?>.</pre>
