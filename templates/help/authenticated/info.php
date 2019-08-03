<?php declare(strict_types=1); ?>
<pre>Type <?= $this->render('/blocks/command', ['command' => 'info']); ?> to get information about your character including stats and health.</pre>
<pre>Type <?= $this->render('/blocks/command', ['command' => 'info playername']); ?> to get information about another player in the same room as you are.</pre>
