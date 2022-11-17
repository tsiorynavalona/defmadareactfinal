<?php

namespace App\Controller\Admin;

use App\Entity\CategoryPost;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryPost::class;
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
