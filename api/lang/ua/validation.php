<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute треба прийняти.',
    'accepted_if' => ':attribute необхідно прийняти коли :other :value.',
    'active_url' => ':attribute не є дійсною URL-адресою.',
    'after' => ':attribute має бути дата після :date.',
    'after_or_equal' => ':attribute має бути датою після або дорівнювати :date.',
    'alpha' => ':attribute має містити лише літери.',
    'alpha_dash' => ':attribute повинен містити лише літери, цифри, тире та підкреслення.',
    'alpha_num' => ':attribute повинен містити лише літери та цифри.',
    'array' => ':attribute має бути масивом.',
    'before' => ':attribute має бути датою перед :date.',
    'before_or_equal' => ':attribute має бути датою, що передує або дорівнює :date.',
    'between' => [
        'array' => ':attribute повинен бути між :min та :max елементами.',
        'file' => ':attribute повинен бути між :min та :max кілобайтами.',
        'numeric' => ':attribute повинен бути між :min та :max.',
        'string' => ':attribute повинен бути між символами :min та :max.',
    ],
    'boolean' => ':attribute має мати значення true або false.',
    'confirmed' => 'Підтвердження :attribute не збігається.',
    'current_password' => 'Пароль невірний.',
    'date' => ':attribute не є дійсною датою.',
    'date_equals' => ':attribute має бути датою, що дорівнює :date.',
    'date_format' => ':attribute не відповідає формату :format.',
    'declined' => ':attribute має бути відхилено.',
    'declined_if' => ':attribute має бути відхилено, якщо :other є :value.',
    'different' => ':attribute та :other повинні бути різними.',
    'digits' => ':attribute має бути :digits цифри.',
    'digits_between' => ':attribute має бути між :min та :max цифрами.',
    'dimensions' => ':attribute має недійсні розміри зображення.',
    'distinct' => ':attribute має повторюване значення.',
    'doesnt_start_with' => ':attribute не може починатися з одного з наступного: :values.',
    'email' => ':attribute має бути дійсною електронною адресою.',
    'ends_with' => ':attribute має закінчуватися одним із наступного: :values.',
    'enum' => 'Вибраний :attribute недійсний.',
    'exists' => 'Даний :attribute не існує.',
    'file' => ':attribute має бути файлом.',
    'filled' => ':attribute повинно мати значення.',
    'gt' => [
        'array' => ':attribute повинен мати більше ніж :value елементів.',
        'file' => ':attribute має бути більшим ніж :value кілобайт.',
        'numeric' => ':attribute має бути більшим ніж :value.',
        'string' => ':attribute має бути більшим ніж :value символів.',
    ],
    'gte' => [
        'array' => ':attribute повинен містити елементи :value або більше.',
        'file' => ':attribute має бути більшим або дорівнювати :value кілобайт.',
        'numeric' => ':attribute має бути більшим або дорівнювати :value.',
        'string' => ':attribute має бути більшим або дорівнювати :value символам.',
    ],
    'image' => ':attribute має бути зображенням.',
    'in' => 'Вибраний :attribute недійсний.',
    'in_array' => ':attribute не існує в :other.',
    'integer' => ':attribute має бути цілим числом.',
    'ip' => ':attribute має бути дійсною IP-адресою.',
    'ipv4' => ':attribute має бути дійсною адресою IPv4.',
    'ipv6' => ':attribute має бути дійсною адресою IPv6.',
    'json' => ':attribute має бути дійсним рядком JSON.',
    'lt' => [
        'array' => ':attribute повинен бути менше ніж :value елементів.',
        'file' => ':attribute повинен бути менше ніж :value кілобайт.',
        'numeric' => ':attribute повинен бути менше ніж :value.',
        'string' => ':attribute повинен бути менше ніж :value символів.',
    ],
    'lte' => [
        'array' => ':attribute не може містити більше ніж :value елементів.',
        'file' => ':attribute має бути меншим або дорівнювати :value кілобайт.',
        'numeric' => ':attribute має бути меншим або дорівнювати :value.',
        'string' => ':attribute має бути меншим або дорівнювати :value символів.',
    ],
    'mac_address' => ':attribute має бути дійсною MAC-адресою.',
    'max' => [
        'array' => ':attribute не може містити більше ніж :max елементів.',
        'file' => ':attribute не повинен перевищувати :max кілобайт.',
        'numeric' => ':attribute не має бути більшим за :max.',
        'string' => ':attribute не має бути більшим за :max символів.',
    ],
    'mimes' => ':attribute має бути файлом типу: :values.',
    'mimetypes' => ':attribute має бути файлом типу: :values.',
    'min' => [
        'array' => ':attribute повинен мати принаймні :min елементів.',
        'file' => ':attribute має бути не менше :min кілобайт.',
        'numeric' => ':Attribute має бути не менше :min.',
        'string' => ':Attribute має бути не менше ніж :min символів.',
    ],
    'multiple_of' => ':attribute має бути кратним :value.',
    'not_in' => 'Вибраний :attribute недійсний.',
    'not_regex' => ':attribute формат недійсний.',
    'numeric' => ':attribute має бути числом.',
    'password' => [
        'letters' => ':attribute повинен містити принаймні одну літеру.',
        'mixed' => ':Attribute має містити щонайменше одну велику та одну малу літери.',
        'numbers' => ':Attribute має містити щонайменше одну цифру.',
        'symbols' => ':attribute повинен містити принаймні один символ.',
        'uncompromised' => 'Даний :attribute з\'явився в результаті витоку даних. Виберіть інший :attribute.',
    ],
    'present' => ':attribute повинно бути присутнім.',
    'prohibited' => ':attribute заборонено.',
    'prohibited_if' => ':attribute заборонено, якщо :other є :value.',
    'prohibited_unless' => ':attribute заборонено, якщо :other не міститься в :values.',
    'prohibits' => ':attribute забороняє присутність :other.',
    'regex' => ':attribute формат недійсний.',
    'required' => 'Поле :attribute обов\'язкове.',
    'required_array_keys' => ':attribute повинно містити записи для: :values.',
    'required_if' => ':attribute є обов\'язковим, якщо :other є :value.',
    'required_unless' => ':attribute є обов\'язковим, якщо :other не міститься в :values.',
    'required_with' => ':attribute є обов\'язковим, якщо присутній :values.',
    'required_with_all' => ':attribute обов\'язкове, якщо присутні :values.',
    'required_without' => ':attribute є обов\'язковим, якщо :values немає.',
    'required_without_all' => ':attribute є обов\'язковим, якщо немає жодного з :values.',
    'same' => ':attribute та :other повинні збігатися.',
    'size' => [
        'array' => ':attribute повинен містити :size елементів.',
        'file' => ':attribute має бути :size кілобайт.',
        'numeric' => ':attribute має бути :size.',
        'string' => ':attribute має бути :size символів.',
    ],
    'starts_with' => ':attribute повинен починатися з одного з наступного: :values.',
    'string' => ':attribute має бути рядком.',
    'timezone' => ':attribute має бути дійсним часовим поясом.',
    'unique' => 'Поле :attribute з цим значенням уже було взято.',
    'uploaded' => ':attribute не вдалося завантажити.',
    'url' => ':attribute має бути дійсною URL-адресою.',
    'uuid' => ':attribute має бути дійсним UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email'       => 'e-mail',
        'password'    => 'пароль',
    ],

];
