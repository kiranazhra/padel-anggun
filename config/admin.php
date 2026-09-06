<?php

return [
    // Options: 'link' (default) | 'modal' | 'dropdown'
    'settings_button' => env('ADMIN_SETTINGS_BUTTON', 'dropdown'),

    // Links for dropdown mode (label, route name)
    'dropdown_links' => [
        ['label' => 'Pengaturan', 'route' => 'admin.settings'],
        ['label' => 'Akun', 'route' => 'admin.profile'],
    ],
];
