<?php declare(strict_types=1); ?>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Good to see you spend some time with my friends. I hope they are all doing ok.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Now you learned all about the different traits it is time to make a choice.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Go to <?= $this->render('/blocks/npc', ['npc' => $this->littleKid]); ?> to learn the deflection trait.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Go to <?= $this->render('/blocks/npc', ['npc' => $this->sorcerer]); ?> to learn the fireball spell.</pre>
<pre class="say"><?= $this->render('/blocks/npc', ['npc' => $this->npc]); ?> says: Or go to <?= $this->render('/blocks/npc', ['npc' => $this->animalTamer]); ?> to learn the animal taming trait.</pre>
