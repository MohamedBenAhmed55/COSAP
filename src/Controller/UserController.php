<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends AbstractController
{


    /**
     * 
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository=$repository;
    }

    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/register", name="api_register", methods={"POST"})
     */
    public function register(ObjectManager $om, UserPasswordEncoderInterface $passwordEncoder, Request $request)
{
    $user = new User();
    $email                  = $request->request->get("email");
    $password               = $request->request->get("password");
    $passwordConfirmation   = $request->request->get("password_confirmation");
    $username               = $request->request->get("username");
    $cin                    = $request->request->get("cin");
    $nom                    = $request->request->get("nom");
    $prenom                 = $request->request->get("prenom");
    $date_nais              = $request->request->get("date_nais");
    $date_embauche          = $request->request->get("date_embauche");
    $genre                  = $request->request->get("Genre");
    $adresse                = $request->request->get("adresse");
    $salaire                = $request->request->get("salaire");
    $phone                  = $request->request->get("phone");
    $fax                    = $request->request->get("fax");
    $pays                   = $request->request->get("pays");
    $matricule              = $request->request->get("matricule");
    $groupe                 = $request->request->get("groupe");
    $poste                  = $request->request->get("poste");
    
    $errors = [];
    
    if($password != $passwordConfirmation)
    {
       $errors[] = "Password does not match the password confirmation.";
    }
    if(strlen($password) < 6)
    {
       $errors[] = "Password should be at least 6 characters.";
    }
    if(!$errors)
    {
       $encodedPassword = $passwordEncoder->encodePassword($user, $password);
       $user->setEmail($email);
       $user->setPassword($encodedPassword);
       $user->setusername($username);
       $user->setCin($cin);
       $user->setNom($nom);
       $user->setPrenom($prenom);
       $user->setDateNai($date_nais);
       $user->setDateEmbauche($date_embauche);
       $user->setAdresse($adresse);
       $user->setSalaire($salaire);
       $user->setPhone($phone);
       $user->setFax($fax);
       $user->setPays($pays);
       $user->setMatricule($matricule);
       $user->setGroupe($groupe);
       $user->setPoste($poste);
       try
       {
           $om->persist($user);
           $om->flush();
           return $this->json([
               'user' => $user
           ]);
       }
       catch(UniqueConstraintViolationException $e)
       {
           $errors[] = "The email provided already has an account!";
       }
       catch(\Exception $e)
       {
           $errors[] = "Unable to save new user at this time.";
       }
    }
    return $this->json([
       'errors' => $errors
    ], 400);
    }


    /**
     * @Route("/login", name="api_login", methods={"POST"})
     */
    public function login()
    {
       return $this->json(['result' => true]);
    }

    /**
     * @Route("/profile", name="api_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile()
    {
        return $this->json([
            'user' => $this->getUser()
         ], 
         200, 
         [], 
         [
            'groups' => ['api']
         ]
      );
    }

   /**
    * @Route("/", name="api_home")
    */
    public function home()
    {
      return $this->json(['result' => true]);
    }

    /**
     * @Route("/api/users", name="getusers" , methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUsers(): JsonResponse
    {
       $users = $this->repository->findAll();   
        return new JsonResponse(
            [
                'users' => $users
            ],
            JsonResponse::HTTP_OK
        );

    }

    /**
     * @Route("/api/modifypassword", name="api_modif_pass" , methods={"POST"})
     */
    public function modifypass(Request $request){
        $modify_user= json_decode(
            $request->getContent(),
            true
        );

        $user= $this->repository->find($modify_user->id);
        $user->setPassword($modify_user->password);
        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        
    }

}
