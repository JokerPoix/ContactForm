<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\ApplicantRequest;
use App\Form\ApplicantRequestType;
use App\Repository\ApplicantRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ApplicantRequestController extends AbstractController
{
    #[Route('/request', name: 'request')]
    public function addApplicantRequest(ApplicantRepository $applicantRepository, SerializerInterface $serializer, Request $request, EntityManagerInterface $em): Response
    {   
        $applicantRequest = new ApplicantRequest;
        $form=$this->createForm(ApplicantRequestType::class, $applicantRequest);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $applicantRequest->setAnswered(false);

            $applicant = new Applicant;       
            $applicant = $applicantRequest->getApplicant();
            $applicantMail = $applicant->getMail();
            if ($applicantRepository->findOneBy(['mail' => $applicantMail]) == null) {
                $em->persist($applicantRequest);
                $em->flush();
            }
            else {
                $applicant = $applicantRepository->findOneBy(['mail' => $applicantMail]);
                $applicant = $applicant->setNonAnswered($applicant->getNonAnswered()+1) ;
                $applicantRequest->setApplicant($applicant);
                $em->persist($applicant);
                $em->persist($applicantRequest);
                $em->flush();
                $requestId = $applicantRequest->getId();
                $jsonContent = $serializer->serialize($applicantRequest,
                'json', ['groups' => ['applicantRequest','applicant' ]]);
                $stream = fopen('jsonRequests/'.$requestId.'.json', 'w');
                fwrite($stream, $jsonContent);
                fclose($stream);
            }
            return $this->redirectToRoute('request_sent');
        }
        return $this->render('request/request.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    #[Route('/request/sent', name: 'request_sent')]
    public function sendApplicantRequest(): Response
    {   
        
        return $this->render('request/request.sent.html.twig', [
            'controller_name' => 'RequestController',
        ]);
    }
}
