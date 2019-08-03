<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: I am sure you will be roaming the realm with a loyal pet right by your side <?= $this->render('/blocks/player', ['player' => $this->player]); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: You can learn the taming trait, but it means you cannot learn the other two traits.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If you are sure you want to learn taming and not the other two, type <?= $this->render('/blocks/command', ['command' => 'learn']); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If you want to learn a different trait instead visit <?= $this->render('/blocks/npc', ['npc' => $this->sorcerer]); ?> or <?= $this->render('/blocks/npc', ['npc' => $this->littleKid]); ?>.</pre>
