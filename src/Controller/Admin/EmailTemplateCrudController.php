<?php

namespace App\Controller\Admin;

use App\Entity\Admin\EmailTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EmailTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EmailTemplate::class;
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
