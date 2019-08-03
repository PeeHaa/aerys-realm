<?php declare(strict_types=1); ?>
<pre class="enemyDamage">You attack <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?> and do <?= $this->render('/blocks/enemyDamage', ['damage' => $this->damage]); ?>.</pre>
