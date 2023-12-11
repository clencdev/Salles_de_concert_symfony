<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('event_name'),
            TextEditorField::new('description'),
            TextField::new('imageFileEvent')
            ->setFormType(VichImageType::class)
            ->onlyOnForms(), // Afficher seulement sur les formulaires
            ImageField::new('event_image')
                ->setBasePath('/upload/img_event') 
                ->onlyOnIndex(), 
            DateTimeField::new('event_date')
                ->renderAsText()
                ->setFormat('yyyy-MM-dd HH:mm:ss')
                ->renderAsNativeWidget(false) ,
        ];
    }
    
}
