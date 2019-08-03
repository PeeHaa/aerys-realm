<?php declare(strict_types=1); ?>
<pre class="playerDamage"><?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?> attacks you and does <?= $this->render('/blocks/playerDamage', ['damage' => $this->damage]); ?>.</pre>
