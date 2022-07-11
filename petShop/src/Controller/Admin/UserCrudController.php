<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('last_name'),
            TextField::new('first_name'),
            AssociationField::new('deliveryAddress'),
            TextField::new('phoneNumber'),
            TextField::new('email'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable( Action::DELETE, Action::NEW, Action::EDIT)
            ;
    }
}
