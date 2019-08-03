<?php declare(strict_types=1); ?>
<pre class="enemyDamage"><?= $this->render('/blocks/player', ['player' => $this->player]); ?> attacks <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?> and does <?= $this->render('/blocks/enemyDamage', ['damage' => $this->damage]); ?>.</pre>
