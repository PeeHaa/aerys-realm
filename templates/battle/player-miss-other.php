<?php declare(strict_types=1); ?>
<pre class="playerMiss"><?= $this->render('/blocks/player', ['player' => $this->player]); ?> tries to hit <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?> but misses.</pre>
