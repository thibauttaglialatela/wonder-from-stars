<?php

namespace App\Controller\Admin\Traits;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

trait ReadDeleteTrait
{
    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::EDIT)
        ->add('index', Action::DETAIL);

        return $actions;
    }
}
