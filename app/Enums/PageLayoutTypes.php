<?php

namespace App\Enums;

enum PageLayoutTypes: string
{
    case HERO_SECTION = 'hero-section';
    case IMAGE_GALLERY = 'image-gallery';
    case HORIZONTAL_TICKER = 'horizontal-ticker';
    case BANNER = 'banner';
    case RICH_TEXT_PAGE = 'rich-text-page';
    case KEY_VALUE_SECTION = 'key-value-section';
    case MAP_LOCATION = 'map-location';
    case IMAGE_CARDS = 'image-cards';
    case RELATIONSHIP_CONTENT = 'relationship-content';
}
