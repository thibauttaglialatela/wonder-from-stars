<?php

namespace App\Twig\Components\Card;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Image
{
    public string $cardImgSrc;
    public string $cardImgAlt;
    public string $cardTitle;
    public $image;
}
