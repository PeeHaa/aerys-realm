<?php declare(strict_types=1); ?>
<pre>To the <?= $this->render('/blocks/direction', ['direction' => $this->direction]); ?> you see <?= $this->render('/blocks/tile', ['tile' => $this->tile]); ?>.</pre>
