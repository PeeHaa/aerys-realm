<?php declare(strict_types=1); ?>
<pre class="enemyDamage"><?= $this->render('/blocks/player', ['player' => $this->player]); ?> killed <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?>. You receive <?= $this->render('/blocks/experiencePoints', ['experiencePoints' => $this->xp]); ?>!</pre>
