<?php declare(strict_types=1); ?>
<pre>You try to pet <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?>, but it scratches you and does <?= $this->render('/blocks/playerDamage', ['damage' => 1]); ?>!</pre>
