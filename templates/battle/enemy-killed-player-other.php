<?php declare(strict_types=1); ?>
<pre class="playerDeath"><?= $this->render('/blocks/player', ['player' => $this->player]); ?> got killed by <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?>!</pre>
