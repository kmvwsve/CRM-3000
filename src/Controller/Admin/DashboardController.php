<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Entity\Admin;
use App\Entity\Societe;
use App\Entity\Customer;
use App\Entity\Admin\EmailTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {	

    	$routeBuilder = $this->get(CrudUrlGenerator::class)->build();

    	if ($this->isGranted('ROLE_ADMIN')) {
    		$class = SocieteCrudController::class;
	    } else {
	    	$class = CustomerCrudController::class;
	    }

		$url = $routeBuilder->setController($class)->generateUrl();

		return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Crm 3000');
    }

	public function configureMenuItems(): iterable
	{
		yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'admin');

		// l'access que ROLE_ADMIN
		if ($this->isGranted('ROLE_ADMIN')) {
			yield MenuItem::linkToCrud('Société', 'far fa-building', Societe::class);
			yield MenuItem::linkToCrud('Utilisateur', 'fas fa-users-cog', Admin::class);
	    }

		yield MenuItem::linkToCrud('Customers', 'fas fa-users', Customer::class);

		yield MenuItem::linkToCrud('Email templates', 'far fa-envelope', EmailTemplate::class);
	}

	public function configureActions(): Actions
	{
        return Actions::new()
            ->addBatchAction(Action::BATCH_DELETE)
            ->add(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DELETE)

            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->add(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
        ;
	}


}
