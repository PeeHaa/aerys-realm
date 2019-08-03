<?php declare(strict_types=1); ?>
<pre><?= $this->render('/blocks/player', ['player' => $this->player]); ?> joins the fight against <?= $this->render('/blocks/enemy', ['enemy' => $this->enemy]); ?>.</pre>
