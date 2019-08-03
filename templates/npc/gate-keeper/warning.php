<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Hi there <?= $this->render('/blocks/player', ['player' => $this->player]); ?>! The <span class="location">path</span> to the <?= $this->render('/blocks/direction', ['direction' => 'south']); ?> is dangerous. I would suggest to not go there before reaching <span class="enemyLevel">Level 3</span>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Type <?= $this->render('/blocks/command', ['command' => 'info']); ?> to see your stats.</pre>
