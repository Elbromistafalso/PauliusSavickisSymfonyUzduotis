<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    
    
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    
    /**
    * @Route("/users", methods="GET")
    */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->transformAll();

        return new JsonResponse($users, Response::HTTP_CREATED);
    }
    
      /**
     * @Route("/users/add", name="add_user", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $name = $data['name'];
        
        $user = $this->userRepository->findOneBy(['name' => $name]);
                                                  
        if($user == NULL){


        if (empty($name)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->userRepository->saveUser($name);

        return new JsonResponse(['status' => 'User created!'], Response::HTTP_CREATED);
            
        } 
        else{
            
            return new JsonResponse(['status' => 'Such username already exists. Please pick another one'], Response::HTTP_CREATED);
            
        }
    }
    
    
     /**
    * @Route("/users/{name}", name="delete_customer", methods={"DELETE"})
    */
    public function delete($name): JsonResponse
   {
       $user = $this->userRepository->findOneBy(['name' => $name]);

       $this->userRepository->removeUser($user);

       return new JsonResponse(['status' => 'User deleted'], Response::HTTP_CREATED);
   }
    
}
