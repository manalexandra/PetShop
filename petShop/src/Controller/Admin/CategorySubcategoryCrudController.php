<?php

namespace App\Controller\Admin;

use App\Entity\CategorySubcategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CategorySubcategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorySubcategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('category'),
            AssociationField::new('subcategory'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable( Action::DELETE)
            ;
    }
}
