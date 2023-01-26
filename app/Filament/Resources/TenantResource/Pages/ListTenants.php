<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  used files template : elcatalogo-admin
 *  by: kamansoft.com
 */

namespace App\Filament\Resources\TenantResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TenantResource;
use App\Filament\Traits\HasDescendingOrder;

class ListTenants extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = TenantResource::class;
}
