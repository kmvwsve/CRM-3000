<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Entity\Admin\EmailTemplate;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class EmailController extends AbstractController
{
	private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    /**
     * Envoyer un mail au client
     * 
     * @Route("/admin/email/{id}", name="admin_email")
     * @IsGranted("ROLE_USER")
     */
    public function index(int $id, Request $request, Customer $customer, MailerInterface $mailer): Response
    {	
    	// Array variables for twig
    	$data = [];

        // Email form
    	$data["firstname"] = $customer->getFirstname();
    	$data["customer_id"] = $customer->getId();
		$form = $this->createFormBuilder()
            ->add('Title', TextType::class)
            ->add('Message', TextareaType::class)
            ->setMethod('POST')
            ->add('send', SubmitType::class, ['label' => 'Envoyer'])
            ->getForm();

        $data["form"] = $form->createView();

    	// Send email
        $form->handleRequest($request);
        $customerEmail = $customer->getEmail();
        if($form->isSubmitted() && $form->isValid()) {
        	$post = $form->getData();

        	$email = (new Email())
	            ->from('shuoz9051@gmail.com')
	            ->to($customerEmail)
	            ->subject($post["Title"])
	            ->text($post["Message"]);

	        $mailer->send($email);
	        $url = $this->adminUrlGenerator
	            ->setController(CustomerCrudController::class)
	            ->setAction(Action::INDEX)
	            ->generateUrl();
	           
	        return $this->redirect($url);
        }

        // Get all email templates
        $repository = $this->getDoctrine()->getRepository(EmailTemplate::class);
        $data["emailTemplates"] = $repository->findAll();
        
        $data["customerEmail"] = $customerEmail;

        // Display
        return $this->render('admin/email/index.html.twig', $data);
    }

    /**
     * Action Ajax pour choisir un template
     * 
     * @Route("/admin/getTemplate", name="admin_email_getTemplate")
     * @IsGranted("ROLE_USER")
     */
    public function getTemplate(Request $request)
    {

		if ($request->isXmlHttpRequest() && $request->request->get("id")) {
			$json = [];

	 		// Get all email templates
	        $repository = $this->getDoctrine()->getRepository(EmailTemplate::class);
	        $template = $repository->find($request->request->get("id"));
	        $json["title"] = $template->getTitle();
	        $json["message"] = $template->getMessage();
		
			return new JsonResponse($json); 
		}    	

    }
}
