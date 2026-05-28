<?php

namespace AdzChappers\BladeComponents\Components;

return [

    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | <x-PREFIX-form />
    |
    */

    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    */

    'components' => [
        'form' => [
            'view' => 'blade-components::forms.form',
            'class' => Forms\Form::class,
        ],
        'form-fieldset' => [
            'view' => 'blade-components::forms.form-fieldset',
            'class' => Forms\FormFieldset::class,
        ],
        'form-error-list' => [
            'view' => 'blade-components::forms.form-error-list',
            'class' => Forms\FormErrorList::class,
        ],
        'form-error' => [
            'view' => 'blade-components::forms.form-error',
            'class' => Forms\FormError::class,
        ],
        'form-button' => [
            'view' => 'blade-components::forms.form-button',
            'class' => Forms\FormButton::class,
        ],
        'form-label' => [
            'view' => 'blade-components::forms.form-label',
            'class' => Forms\FormLabel::class,
        ],
        'form-input' => [
            'view' => 'blade-components::forms.form-input',
            'class' => Forms\FormInput::class,
        ],
        'form-textarea' => [
            'view' => 'blade-components::forms.form-textarea',
            'class' => Forms\FormTextarea::class,
        ],
        'form-checkbox' => [
            'view' => 'blade-components::forms.form-checkbox',
            'class' => Forms\FormCheckbox::class,
        ],
        'form-radio' => [
            'view' => 'blade-components::forms.form-radio',
            'class' => Forms\FormRadio::class,
        ],
        'form-select' => [
            'view' => 'blade-components::forms.form-select',
            'class' => Forms\FormSelect::class,
        ],
    ],
];
