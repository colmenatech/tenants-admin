<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  for:
 *  by: kamansoft.com
 */

namespace App\Filament\Resources\SubscriptionResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;

class TenantsRelationManager extends RelationManager
{
    protected static string $relationship = 'tenants';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('Tenant');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tenants');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                Toggle::make('status')
                    ->label(__('Status'))
                    ->rules(['boolean'])
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('name')
                    ->label(__('Name'))
                    ->rules(['max:255', 'string'])
                    ->unique('tenants', 'name', fn(?Model $record) => $record)
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('domain')
                    ->label(__('Domain'))
                    ->rules(['max:255', 'string'])
                    ->unique('tenants', 'domain', fn(?Model $record) => $record)
                    ->placeholder('Domain')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('database')
                    ->label(__('Database'))
                    ->rules(['max:255', 'string'])
                    ->unique(
                        'tenants',
                        'database',
                        fn(?Model $record) => $record
                    )
                    ->placeholder('Database')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                FileUpload::make('image')
                    ->label(__('Image'))
                    ->rules(['image', 'max:2048'])
                    ->image()
                    ->preserveFilenames()
                    ->directory(
                        request()->host() . '/uploads/' . 'Tenants/images/'
                    )
                    ->placeholder('Image')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                KeyValue::make('system_settings')
                    ->label(__('System Settings'))
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                KeyValue::make('settings')
                    ->label(__('Settings'))
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('user_id')
                    ->label(__('User'))
                    ->rules(['exists:users,id'])
                    ->relationship('user', 'name')
                    ->searchable()
                    ->placeholder('User')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('tenant_request_id')
                    ->label(__('Tenant Request'))
                    ->rules(['exists:tenant_requests,id'])
                    ->relationship('tenantRequest', 'email')
                    ->searchable()
                    ->placeholder('Tenant Request')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('status')->label(__('Status')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->limit(50),
                Tables\Columns\TextColumn::make('domain')
                    ->label(__('Domain'))
                    ->limit(50),
                Tables\Columns\TextColumn::make('database')
                    ->label(__('Database'))
                    ->limit(50),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('Image'))
                    ->rounded(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->limit(50),
                Tables\Columns\TextColumn::make('subscription.name')
                    ->label(__('Subscription'))
                    ->limit(50),
                Tables\Columns\TextColumn::make('tenantRequest.email')
                    ->label(__('Tenant Request'))
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('user_id')->relationship(
                    'user',
                    'name'
                ),

                MultiSelectFilter::make('subscription_id')->relationship(
                    'subscription',
                    'name'
                ),

                MultiSelectFilter::make('tenant_request_id')->relationship(
                    'tenantRequest',
                    'email'
                ),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([Tables\Actions\DetachBulkAction::make()]);
    }
}
