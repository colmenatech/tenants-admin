<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'subscriptions' => [
        'name' => 'Subscriptions',
        'index_title' => 'Subscriptions List',
        'new_title' => 'New Subscription',
        'create_title' => 'Create Subscription',
        'edit_title' => 'Edit Subscription',
        'show_title' => 'Show Subscription',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'entities_threshold' => 'Entities Threshold',
            'features_gates' => 'Features Gates',
        ],
    ],

    'tags' => [
        'name' => 'Tags',
        'index_title' => 'Tags List',
        'new_title' => 'New Tag',
        'create_title' => 'Create Tag',
        'edit_title' => 'Edit Tag',
        'show_title' => 'Show Tag',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
        ],
    ],

    'tenant_requests' => [
        'name' => 'Tenant Requests',
        'index_title' => 'TenantRequests List',
        'new_title' => 'New Tenant request',
        'create_title' => 'Create TenantRequest',
        'edit_title' => 'Edit TenantRequest',
        'show_title' => 'Show TenantRequest',
        'inputs' => [
            'email' => 'Email',
            'phone' => 'Phone',
            'description' => 'Description',
            'image' => 'Image',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'tenants' => [
        'name' => 'Tenants',
        'index_title' => 'Tenants List',
        'new_title' => 'New Tenant',
        'create_title' => 'Create Tenant',
        'edit_title' => 'Edit Tenant',
        'show_title' => 'Show Tenant',
        'inputs' => [
            'status' => 'Status',
            'name' => 'Name',
            'domain' => 'Domain',
            'database' => 'Database',
            'image' => 'Image',
            'system_settings' => 'System Settings',
            'settings' => 'Settings',
            'user_id' => 'User',
            'subscription_id' => 'Subscription',
            'tenant_request_id' => 'Tenant Request',
        ],
    ],
];
