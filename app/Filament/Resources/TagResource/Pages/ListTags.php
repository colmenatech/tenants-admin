<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  used files template : elcatalogo-admin
 *  by: kamansoft.com
 */

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListTags extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = TagResource::class;
}
