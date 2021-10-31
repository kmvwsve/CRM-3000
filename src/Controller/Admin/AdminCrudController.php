<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Utilisateurs
 * 
 */
class AdminCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
		->setEntityLabelInSingular('USER')
		->setEntityLabelInPlural('USERS')
		->setSearchFields(['name'])
		->setDefaultSort(['username' => 'DESC']);
	}


	public function configureFilters(Filters $filters): Filters
	{
		return $filters->add(EntityFilter::new('societe'));
	}

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('societe');
        yield TextField::new('username');
        yield TextField::new('password')
            ->hideOnIndex()
            ->setFormType(PasswordType::class);
        yield ArrayField::new('roles');
    }
}
