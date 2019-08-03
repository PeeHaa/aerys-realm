<?php declare(strict_types=1); ?>
<pre class="enemyDamage">You killed <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?> and received <?= $this->render('/blocks/experiencePoints', ['experiencePoints' => $this->xp]); ?>!</pre>
