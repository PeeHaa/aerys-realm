<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Do you want to learn more about magic traits?. That's awesome!</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: If you want I can teach you the fireball spell. This is an active trait and can only be used once in a fight.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Although you can only use it once it will deal a massive blow to you foes.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: There is one more trait you want to learn about.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Go see the <?= $this->render('/blocks/npc', ['npc' => $this->animalTamer]); ?> which is <?= $this->render('/blocks/direction', ['direction' => 'south east']); ?> from here.</pre>
