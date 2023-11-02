<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Traits\ReadOnlyTrait;
use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PictureCrudController extends AbstractCrudController
{
    use ReadOnlyTrait;

    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('Date'),
            TextField::new('Title')->setLabel('Titre'),
            ImageField::new('url'),
            AssociationField::new('Medias'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('Picture')
            ->setEntityLabelInPlural('Pictures');
    }
}
