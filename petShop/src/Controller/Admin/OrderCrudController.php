<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('orderNumber')->onlyOnIndex(),
            IntegerField::new('orderNumber')->onlyOnForms()->setDisabled(),
            AssociationField::new('user')->onlyOnIndex(),
            AssociationField::new('user')->onlyOnForms()->setDisabled(),
            AssociationField::new('deliveryAddress')->onlyOnIndex(),
            AssociationField::new('deliveryAddress')->onlyOnForms()->setDisabled(),
            TextField::new('status')->onlyOnIndex(),
            ChoiceField::new('status')->setChoices([
                'Pending'=>'Pending',
                'Canceled'=>'Canceled',
                'Delivered'=>'Delivered',
            ])->onlyOnForms(),
            IntegerField::new('totalPrice')->onlyOnIndex(),
            IntegerField::new('totalPrice')->onlyOnForms()->setDisabled(),
            DateTimeField::new('createdAt')->setFormat('dd.MM.yyyy')->onlyOnIndex(),
            DateTimeField::new('createdAt')->setFormat('dd.MM.yyyy')->onlyOnForms()->setDisabled(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable( Action::DELETE, Action::NEW)
            ;
    }
}
