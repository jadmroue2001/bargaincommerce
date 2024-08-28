<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form shadow p-3 my-3 bg-light" >
    <h3 style="text-align:center"><?= __("Login")?></h3>
    <div class="text-center"><?= $this->Flash->render() ?></div>
    <?= $this->Form->create() ?>
    <fieldset >
    <div class="d-grid gap-3">
        <div class="d-flex justify-content-center p-2">
            <?= $this->Form->control(__('username'), ['required' => true, 'name'=> 'username', 'class'=>'form-control']) ?>
        </div>
        <div class="d-flex justify-content-center p-2">
            <?= $this->Form->control(__('password'), ['required' => true, 'name'=>'password', 'class'=>'form-control','type'=>'password']) ?>
        </div>
    </div>

    </fieldset>
    <div style="text-align: center;">
    <?= $this->Form->submit(__('Login'),['class'=>'m-2 btn btn-primary']) ?>
    </div>

    <?= $this->Form->end() ?>

</div>
