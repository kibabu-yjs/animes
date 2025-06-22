<?php

namespace App\Filament\Resources;

use App\Blocks\HeroBlock;
use App\Enums\PageStatus;
use App\Filament\Resources\PageBuilderResource\Pages;
use App\Filament\Resources\PageBuilderResource\Pages\CreatePageBuilder;
use App\Filament\Resources\PageBuilderResource\Pages\EditPageBuilder;
use App\Filament\Resources\PageBuilderResource\Pages\ListPageBuilders;
use App\Filament\Resources\PageBuilderResource\RelationManagers;
use App\Models\PageBuilder;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SkyRaptor\FilamentBlocksBuilder\Forms\Components\BlocksInput;
use Illuminate\Support\Str;

class PageBuilderResource extends Resource
{
    protected static ?string $model = PageBuilder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pages Builder';

    public static function getNavigationGroup(): ?string
    {
        return config('filament-page-builder.navigation_group', 'Content');
    }

    public static function getNavigationIcon(): ?string
    {
        return config('filament-page-builder.navigation_icon', 'heroicon-o-rectangle-stack');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                self::getFormSchema($form)
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (PageStatus $state): string => match ($state) {
                        PageStatus::DRAFT => 'info',
                        PageStatus::PUBLISHED => 'success',
                        PageStatus::ARCHIVED => 'warning',
                    })
                    ->formatStateUsing(fn (PageStatus $state): string => $state->name)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make()->color('info'),
                EditAction::make()->color('info'),
                Action::make('publish')
                    ->icon('heroicon-s-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (PageBuilder $record) => $record->update(['status' => PageStatus::PUBLISHED])),
                Action::make('archive')
                    ->icon('heroicon-s-archive-box-arrow-down')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(fn (PageBuilder $record) => $record->update(['status' => PageStatus::ARCHIVED])),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageBuilders::route('/'),
            'create' => CreatePageBuilder::route('/create'),
            'edit' => EditPageBuilder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): EloquentBuilder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getFormSchema(Form $form): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

            TextInput::make('slug')->readOnly(),

            Select::make('status')
                ->label('Status')
                ->default(PageStatus::DRAFT->value)
                ->options(collect(PageStatus::cases())->mapWithKeys(fn ($case) => [
                    $case->value => $case->name,
                ]))->required(),

            Section::make('Page builder')
                ->schema([
                    BlocksInput::make('content')
                        ->blocks([
                            HeroBlock::block($form),
                        ]),
                ]),
        ];
    }
}