<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ActuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actu::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('text_content'),
            TextField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->onlyOnForms(), // Afficher seulement sur les formulaires
            ImageField::new('images')
                ->setBasePath('/upload/img_actu') 
                ->onlyOnIndex(), 
            DateTimeField::new('publication_date')
                ->onlyOnIndex()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }
    
}
