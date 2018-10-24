<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'maxlength' => true]) ?>

                <?= $form->field($model, 'email')->input('email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'type')->dropdownList([1 => 'Person', 2 => 'Organization']) ?>

            <div id="entrepreneurFields"<?= ((int)$model->type !== 2 ? '' : ' style="display: none;"') ?>>
                <?= $form->field($model, 'is_entrepreneur')->checkbox() ?>
                
                <?= $form->field($model, 'inn', ['options' => ArrayHelper::merge(
                        ['id' => 'field-signupform-inn'], (($model->is_entrepreneur) ? [] : ['style' => 'display: none;'])
                    )])
                    ->textInput(['type' => 'number', 'onKeyPress' => 'if(this.value.length==12) return false;',
                        'min' => '100000000000', 'max' => '999999999999']) ?>
            </div>
            
            <div id="organizationFields"<?= ((int)$model->type === 2 ? '' : ' style="display: none;"') ?>>
                <?= $form->field($model, 'org_inn')->textInput(['type' => 'number',
                        'onKeyPress' => 'if(this.value.length==10) return false;',
                        'min' => '1000000000', 'max' => '9999999999',
                    ]) ?>
                
                <?= $form->field($model, 'org_name')->textInput(['maxlength' => true]) ?>
            </div>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$toggleTypeScript = <<<JS
$('#signupform-type').on('change', function (event) {
	if(event.target.value == 1) {
        $('#entrepreneurFields').show();
        $('#organizationFields').hide();
        $('#signupform-org_inn').val('');
        $('#signupform-org_name').val('');
    } else {
        $('#entrepreneurFields').hide();
        $('#signupform-is_entrepreneur').prop("checked", false);
        $('#signupform-inn').val('');
        $('#organizationFields').show();
    }
});
JS;
$this->registerJs($toggleTypeScript);
$toggleIsEntrepreneurScript = <<<JS
$('#signupform-is_entrepreneur').on('change', function (event) {
	if(event.target.checked) {
        $('#field-signupform-inn').show();
    } else {
        $('#field-signupform-inn').hide();
    }
});
JS;
$this->registerJs($toggleIsEntrepreneurScript);
?>
