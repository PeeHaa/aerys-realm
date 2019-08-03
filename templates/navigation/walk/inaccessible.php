<?php declare(strict_types=1); ?>
<pre>You try to walk to the <?= $this->render('/blocks/direction', ['direction' => $this->direction]); ?>, but are blocked by <?= $this->render('/blocks/tile', ['tile' => $this->tile]); ?>.</pre>
