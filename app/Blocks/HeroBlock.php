<?php 

namespace App\Blocks;

use App\Enums\PageLayoutTypes;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use SkyRaptor\FilamentBlocksBuilder\Forms\Components\BlocksInput;

class HeroBlock extends \SkyRaptor\FilamentBlocksBuilder\Blocks\Contracts\Block
{
    public static function block(Form $form): Components\Builder\Block
    {
        return parent::block($form)->schema([
            TextInput::make('title')
                ->required(),
            TextInput::make('subtitle'),

            FileUpload::make('image')
                ->panelLayout('grid')
                ->directory('page-builder')
                ->image()
                ->required()
                ->disk(config('filament-page-builder.disk')),

            TextInput::make('button-text'),
            TextInput::make('button-path'),
        ]);
    }

    public static function view(): string
    {
        return 'hero-block';
    }
}