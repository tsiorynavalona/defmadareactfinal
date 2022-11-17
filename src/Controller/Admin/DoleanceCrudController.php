<?php

namespace App\Controller\Admin;

use App\Entity\Doleance;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DoleanceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Doleance::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
