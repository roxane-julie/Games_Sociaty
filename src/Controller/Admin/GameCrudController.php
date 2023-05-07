<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            IntegerField::new('time'),
            IntegerField::new('age'),
            TextEditorField::new('description'),
            TextEditorField::new('content'),
            DateField::new('released'),
            TextField::new('players'),
            AssociationField::new('categories'),
            ImageField::new('picture')->setRequired(false)->setBasePath('uploads')->setUploadDir('public/uploads')
        ];
    }
    
}
