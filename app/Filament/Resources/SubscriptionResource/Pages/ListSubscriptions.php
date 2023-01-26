<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  used files template : elcatalogo-admin
 *  by: kamansoft.com
 */

namespace App\Filament\Resources\SubscriptionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\SubscriptionResource;

class ListSubscriptions extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = SubscriptionResource::class;
}
