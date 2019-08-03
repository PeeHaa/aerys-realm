<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Welcome back <?= $this->render('/blocks/player', ['player' => $this->player]); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Please tell me you resolved the situation.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If so type <?= $this->render('/blocks/command', ['command' => 'quest']); ?> to get yor reward.</pre>
