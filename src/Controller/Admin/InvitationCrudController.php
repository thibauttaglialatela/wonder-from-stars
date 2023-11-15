<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Traits\ReadDeleteTrait;
use App\Entity\Invitation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InvitationCrudController extends AbstractCrudController
{
    use ReadDeleteTrait;

    public static function getEntityFqcn(): string
    {
        return Invitation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            TextField::new('uuid')->hideWhenCreating(),
            AssociationField::new('reader')->hideWhenCreating(),
        ];
    }
}
