<?php declare(strict_types=1); ?>
<pre class="playerDamage"><?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?> attacks <?= $this->render('/blocks/player', ['player' => $this->player]); ?> and does <?= $this->render('/blocks/playerDamage', ['damage' => $this->damage]); ?>.</pre>
