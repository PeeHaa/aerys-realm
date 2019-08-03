<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: I heard you spoke to <?= $this->render('/blocks/npc', ['npc' => $this->littleKid]); ?>. He's a smart little fella.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Now go talk to <?= $this->render('/blocks/npc', ['npc' => $this->sorcerer]); ?> over in the <?= $this->render('/blocks/direction', ['direction' => 'south west']); ?>.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: He has some more information about traits.</pre>
