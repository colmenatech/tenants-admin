<?php
/**
 *  Generated with: https://github.com/kamansoft/vemto-filament-plugin
 *  for: elcatalogo-admin
 *  by: kamansoft.com
 */

namespace App\Filament\Resources;

use Illuminate\Support\Str;
use App\Models\Subscription;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\SubscriptionResource\Pages;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('Subscription');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Subscriptions');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('name')
                        ->label(__('Name'))
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('description')
                        ->label(__('Description'))
                        ->rules(['string'])
                        ->disableAllToolbarButtons()
                        /*->disableToolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'codeBlock',
                            'h2',
                            'h3',
                            //'italic',
                            //'link',
                            'strike',
                        ])*/
                        ->required()
                        ->placeholder('Description')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('price')
                        ->label(__('Price'))
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Price')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                   /* KeyValue::make('entities_threshold')
                        ->label(__('Entities Threshold'))
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('features_gates')
                        ->label(__('Features Gates'))
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),*/
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description'))
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Price'))
                    ->toggleable()
                    ->searchable(true, null, true),
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [
            //SubscriptionResource\RelationManagers\TenantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'view' => Pages\ViewSubscription::route('/{record}'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
