<?php declare(strict_types=1); ?>
<pre>You walk to the <?= $this->render('/blocks/direction', ['direction' => $this->direction]); ?> and see <?= $this->render('/blocks/tile', ['tile' => $this->tile]); ?>.</pre>
