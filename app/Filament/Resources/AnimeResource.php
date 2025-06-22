<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnimeResource\Pages;
use App\Filament\Resources\AnimeResource\RelationManagers;
use App\Models\Anime;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnimeResource extends Resource
{
    protected static ?string $model = Anime::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'fullname')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('episodes')
                ->required()
                ->numeric(),
                Forms\Components\DatePicker::make('date_of_publication')
                ->required(),
                Forms\Components\FileUpload::make('image')
                ->image()
                ->directory('animes')
                ->required(),
                Forms\Components\RichEditor::make('synopsis')
                    ->required()
                    ->columnSpan(2)
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                

                Tables\Columns\TextColumn::make('episodes')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_publication')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.fullname')
                    ->label('Author')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAnimes::route('/'),
            'create' => Pages\CreateAnime::route('/create'),
            'view' => Pages\ViewAnime::route('/{record}'),
            'edit' => Pages\EditAnime::route('/{record}/edit'),
        ];
    }
}
