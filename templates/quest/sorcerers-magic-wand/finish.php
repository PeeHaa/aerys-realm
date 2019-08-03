<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: You told my dad I was the one who had <?= $this->render('/blocks/item', ['item' => $this->magicWand]); ?>??</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Well thanks anyway... here is <?= $this->render('/blocks/experiencePoints', ['experiencePoints' => 10]); ?> for your troubles.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Also...</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Do you remember that old man that gave you directions to my father earlier?</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: He is willing to teach you a new trait for helping me out. Go find him for more information.</pre>
