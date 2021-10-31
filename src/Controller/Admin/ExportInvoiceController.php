<?php

namespace App\Controller\Admin;

use App\Entity\Societe;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExportInvoiceController extends AbstractController
{
    /**
     * Génération Facture
     * @Route("/admin/export/invoice/{id}", name="admin_export_invoice")
     * 
     */
    public function index(int $id, Societe $societe): Response
    {	
    	
    	$name = $societe->getName();
    	$nameResponsable = "";
    	if ($resp = $societe->getResponsable()) {
    		$nameResponsable = $resp->getUsername();
    	}
    	
    	$users = $societe->getUsers();

    	$html = "<h1>".$name."</h1>";
    	$html.= "<h2>Responsable:  ".$nameResponsable."</h2>";
    	$html.= "<h2>Utilisateurs:</h2>";
    	if($users) {
    		$html.= "<ol>";
	    	foreach ($users as $key => $user) {
	    		$html.= "<li>".$user->getUsername()."</li>";
	    	}
	    	$html.= "</ol>"; 		
    	}

    	// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("facture_".$name."_".date("Ymd")."pdf", [
            "Attachment" => true
        ]);
        exit();
    }
}
