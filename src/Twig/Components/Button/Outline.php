<?php

namespace App\Twig\Components\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Outline
{
    public string $buttonText;
    public string $type;

}
