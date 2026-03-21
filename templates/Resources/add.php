<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resource $resource
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Resources'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="resources form content">
            <?= $this->Form->create($resource) ?>
            <fieldset>
                <legend><?= __('Add Resource') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('published_date', ['empty' => true]);
                    echo $this->Form->control('type');
                    echo $this->Form->control('url_link');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
