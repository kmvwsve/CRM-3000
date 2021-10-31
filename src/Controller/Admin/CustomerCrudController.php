<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;


/**
 * Customers
 * 
 */
class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function createEntity(string $entityFqcn) {
        $customer = new Customer();

		$dateImmutable = \DateTime::createFromFormat('Y-m-d H:i:s', strtotime('now')); 

        $customer->setIsAnswered(false);
        $customer->setIsConsumed(false);
        $customer->setDateCreated(new \DateTime());

        return $customer;
    }

    public function configureFields(string $pageName): iterable
    {
		yield TextField::new('firstname');
		yield TextField::new('lastname');
		yield EmailField::new('email');
		yield BooleanField::new('isAnswered')->setFormTypeOption('disabled', true)->onlyOnIndex();
		yield BooleanField::new('isConsumed')->setFormTypeOption('disabled', true)->onlyOnIndex();

		$dateCreated = DateTimeField::new('dateCreated')->setFormTypeOptions([
			'html5' => true,
			'years' => range(date('Y'), date('Y') + 5),
			'widget' => 'single_text',
		]);

		$dateLastEmail = DateTimeField::new('dateLastEmail')->setFormTypeOptions([
			'html5' => true,
			'years' => range(date('Y'), date('Y') + 5),
			'widget' => 'single_text',
		]);

		yield $dateCreated->setFormTypeOption('disabled', true)->onlyOnIndex();
		yield $dateLastEmail->setFormTypeOption('disabled', true)->onlyOnIndex();
    }

    public function configureActions(Actions $actions): Actions
    {
		$sendEmail = Action::new('sendEmail', 'Send')
			->linkToRoute("admin_email", function (Customer $customer): array {
                return [
                    'id' => $customer->getId()
                ];
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $sendEmail)
        ;
    }
}
