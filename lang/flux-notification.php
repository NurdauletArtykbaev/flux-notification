<?php
return [
    'notification' => [
        'plural' => 'Уведомления',
        'singular' => 'Уведомления',
        'fields' => [
            "key" => 'Ключ',
            "text" => 'Текст',
            "description" => 'Описание',
            "subject" => 'Загаловок',
        ]
    ],
    'notification_type' => [
        'plural' => 'Типы уведомления',
        'singular' => 'Тип уведомления',
        'fields' => [
            "name" => 'Название',
            "key" => 'Ключ',
            "is_active" => 'Опубликован',
        ]
    ],
    'quick_notification' => [
        'plural' => 'бысрые уведомлений',
        'singular' => 'бысрые уведомлений',
        'fields' => [
            "text" => 'Текст',
            "description" => 'Описание',
            "subject" => 'Загаловок',
            "to_all" => 'Отправить всем',
            "image" => 'Фото',
            "key" => 'Ключ',
            "is_active" => 'Опубликован',
        ]
    ],
];
