<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ApplicantRequestRepository;
use App\Repository\ApplicantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index( ApplicantRequestRepository $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $allRequests = $request->findAll();

        return $this->render('admin/index.html.twig', [
            'requests' => $allRequests,
        ]);
    }

    #[Route('/admin/request/{id}', name: 'admin_answering')]
    public function answerRequest( ApplicantRequestRepository $request, $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $requestToAnswer = $request->findOneBy(['id'=>$id]);

        return $this->render('admin/request.answer.html.twig', [
            'request' => $requestToAnswer,
        ]);
    }

    #[Route('/admin/request/answered/{id}', name: 'admin_answered')]
    public function answeredRequest( EntityManagerInterface $em, ApplicantRequestRepository $request, $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $requestToAnswer = $request->findOneBy(['id'=> $id]);
        $requestToAnswer->setAnswered(true);
        $applicant = $requestToAnswer->getApplicant();
        if ($requestToAnswer->getAnswered() == true){
            $applicant = $applicant->setNonAnswered($applicant->getNonAnswered()-1) ;
        }        $em->persist($requestToAnswer);
        $em->persist($applicant);
        $em->flush();

        return $this->render('admin/request.answer.html.twig', [
            'request' => $requestToAnswer,
        ]);
    }

    #[Route('/admin/request/unanswered/{id}', name: 'admin_unanswered')]
    public function unAnswerRequest( EntityManagerInterface $em, ApplicantRequestRepository $request, $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $requestToAnswer = $request->findOneBy(['id'=> $id]);
        $requestToAnswer->setAnswered(false);
        $applicant = $requestToAnswer->getApplicant();
        if ($requestToAnswer->getAnswered() == false){
            $applicant = $applicant->setNonAnswered($applicant->getNonAnswered()+1) ;
        }
        $em->persist($requestToAnswer);
        $em->persist($applicant);
        $em->flush();

        return $this->render('admin/request.answer.html.twig', [
            'request' => $requestToAnswer,
        ]);
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function usersRequesting( ApplicantRepository $applicants): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $applicants = $applicants->findAll();
        
        return $this->render('admin/applicants.html.twig', [
            'applicants' => $applicants,
        ]);
    }

    #[Route('/admin/user/{id}/requests', name: 'admin_user_requests')]
    public function userRequests( ApplicantRepository $applicant, ApplicantRequestRepository $requests, $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $applicant = $applicant->findOneBy(['id'=>$id]);
        $applicantsRequests = $requests->findBy(['applicant' => $applicant]);
        
        return $this->render('admin/index.html.twig', [
            'applicant' => $applicant,
            'requests' => $applicantsRequests
        ]);
    }
}
