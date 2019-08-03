<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Good choice <?= $this->render('/blocks/player', ['player' => $this->player]); ?>!</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Your first stop is <?= $this->render('/blocks/npc', ['npc' => $this->littleKid]); ?> <?= $this->render('/blocks/direction', ['direction' => 'north west']); ?> from here.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Come back to me after speaking to him.</pre>
