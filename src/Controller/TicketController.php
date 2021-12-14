<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\HttpFoundation\Request;
#[Route('/ticket')]

class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'ticket')]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }
    #[Route('/', name: 'home')]
    public function home(){
        return $this->render('ticket/home.html.twig');
    }
}
class GestionTicket extends AbstractControllerController
{
    #[Route('/new/{title}/{nom}/{description}', name: 'add_ticket')]
    public function add_ticket ($title,$name,$description): Response
    {   $ticket=new Ticket();
        $ticket ->setTitle($title);
        $ticket ->setName($name);
        $ticket ->setDescription($description);
        $ticket ->setStatut("EN ATTENTE");
        $ticket ->setDate(new \DateTime() ) ;

        $entitymanager= $this ->getDoctrine()->getManager();
        $entitymanager-> persist($ticket);
        $entitymanager->flush();

        return $this->redirectToRoute('tickets_list');
    }
    #[Route('/update/{id}/{title}/{nom}/{description}/{statut}', name: 'edit_ticket')]
    public function edit_ticket($title,$name,$description,$id,$statut )
    {

        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->find($id);
        if ($ticket){
            $ticket->setTitle($title);
            $ticket->setName($name);
            $ticket->setDescription($description);
            $ticket->setStatut($statut);
            $ticket->setDate(new \DateTime());

            $Manager = $this->getDoctrine()->getManager();
            $Manager->persist($ticket);
            $Manager->flush();
            dd();

        }

        return $this->redirectToRoute('tickets_list');}

    #[Route('/del/ticket/{id}', name: 'delete_ticket')]
    public function delete_ticket(Request $request, $id){
        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->find($id);
        $Manager = $this->getDoctrine()->getManager();
        $Manager->remove($ticket);
        $Manager->flush();
        dd();



        return $this->redirectToRoute('tickets_list');
    }
    #[Route('/list', name: 'tickets_list')]
    public function list( Request $request): Response
    {
        $tickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();


        return $this->render('ticket/index.html.twig', ['tickets' => $tickets]);
    }
}

