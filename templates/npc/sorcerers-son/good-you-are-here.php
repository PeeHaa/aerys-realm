<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Sorry to bother you <?= $this->render('/blocks/player', ['player' => $this->player]); ?>, but I really need your help!</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: I "accidentally" took my father's magic wand. And now I heard he is looking for it.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If he finds out I took it I am dead! Can you please bring him his magic wand?</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Please help me out and type <?= $this->render('/blocks/command', ['command' => 'quest']); ?> to accept this quest and I will make it worth your time.</pre>
