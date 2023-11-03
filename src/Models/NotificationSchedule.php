<?php

namespace Saham\SharedLibs\Models;

use Saham\SharedLibs\Models\Abstracts\BaseModel;

class NotificationSchedule extends BaseModel
{
    private $fields = [
        'type_push' => 'boolean',
        'type_email' => 'boolean',
        'type_sms' => 'boolean',
        'type_whatsapp' => 'boolean',
        'users_last_order_between_from' => 'date',
        'users_last_order_between_to' => 'date',
        'users_no_orders' => 'boolean',
        'all_users' => 'boolean',
        'all_partners' => 'boolean',
        'all_drivers' => 'boolean',
        'body' => 'string',
        'title' => 'string',
        'is_recurring' => 'boolean',
        'schedule_at' => 'string',
        'sent_at' => 'string',
    ];

    protected $dates = ['created_at', 'updated_at', 'schedule_at', 'sent_at'];
}
