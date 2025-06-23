<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;

class FirstBlock extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('first')
            ->schema([
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required(),
                \Filament\Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    ->required(),
                \Filament\Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('animes')
                    ->required(),
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}