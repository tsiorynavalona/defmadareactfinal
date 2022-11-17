<?php

namespace App\Controller\Admin;

use DateTime;

use DateTimeImmutable;
use App\Entity\BlogPost;
use App\Repository\CategoryPostRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BlogPostCrudController extends AbstractCrudController

{
    private $categorieRepository;
    
    public function __construct(CategoryPostRepository $category)
    {
        $this->categorieRepository = $category;
    }

    public static function getEntityFqcn(): string
    {
        return BlogPost::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $categories = $this->categorieRepository->findAll();
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            // ChoiceField::new('categories')
            //         ->allowMultipleChoices()
            //         ->autocomplete()
            //         ->setChoices($categories)
            //         ->renderExpanded(true)
            
            AssociationField::new('categories'),
            DateTimeField::new('createdAt')->setValue(new DateTime()),
            ImageField::new('photoFilename')
                ->setUploadDir('/assets/images/'),

        ];
    }

    public function createEntity(string $entityFqcn) {
        $entity = new BlogPost();
        $entity->setCreatedAt(new DateTimeImmutable());
        $entity->setIsPublished(false);

        return $entity;
    }
    
}
