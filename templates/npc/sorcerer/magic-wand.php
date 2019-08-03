<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Hello <?= $this->render('/blocks/player', ['player' => $this->player]); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: I am looking for <?= $this->render('/blocks/item', ['item' => $this->magicWand]); ?>. I think I misplaced it. Have you seen it by any chance?</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If so type <?= $this->render('/blocks/command', ['command' => 'give']); ?> to give it back to me please.</pre>
