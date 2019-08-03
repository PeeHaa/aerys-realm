<?php declare(strict_types=1); ?>
<pre class="enemyMiss"><?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?> tries to hit <?= $this->render('/blocks/player', ['player' => $this->player]); ?> but misses.</pre>
