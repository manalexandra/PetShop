<?php

namespace App\Controller\Admin;

use App\Entity\DeliveryAddress;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DeliveryAddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DeliveryAddress::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('country'),
            TextField::new('county'),
            TextField::new('city'),
            TextField::new('street'),
            IntegerField::new('number'),
            IntegerField::new('postalCode'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable( Action::DELETE, Action::NEW, Action::EDIT)
            ;
    }
}
