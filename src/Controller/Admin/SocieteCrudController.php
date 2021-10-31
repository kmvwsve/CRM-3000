<?php

namespace App\Controller\Admin;

use App\Entity\Societe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
/**
 * Société
 * 
 */
class SocieteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Societe::class;
    }

    public function configureFields(string $pageName): iterable
    {
		yield AssociationField::new('responsable');
		yield TextField::new('name');
    }

    public function configureActions(Actions $actions): Actions
    {
		$exportFacture = Action::new('exportFacture', 'Export Facture')
			->linkToRoute("admin_export_invoice", function (Societe $societe): array {
                return [
                    'id' => $societe->getId()
                ];
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $exportFacture)
        ;
    }

}
