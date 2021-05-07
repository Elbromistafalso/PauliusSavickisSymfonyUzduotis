<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupController extends AbstractController
{
    
    
    private $groupRepository;
    
    private $userRepository;

    public function __construct(GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }
    
    /**
    * @Route("/groups", methods="GET")
    */
    public function index(GroupRepository $groupRepository)
    {
        $groups = $groupRepository->transformAll();

        return new JsonResponse($groups, Response::HTTP_CREATED);
    }
    
      /**
     * @Route("/groups/add", name="add_group", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        
        $this->groupRepository->saveGroup();

        return new JsonResponse(['status' => 'Group created!'], Response::HTTP_CREATED);
            
    }
    
    
      /**
     * @Route("/groups/{id}", name="delete_group", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        
         $group = $this->groupRepository->findOneBy(['id' => $id]);

         $this->groupRepository->removeGroup($group);

         return new JsonResponse(['status' => 'Group deleted'], Response::HTTP_CREATED);
    }
    
      /**
     * @Route("/groups/addUser/{groupId}/{name}", name="add_user_to_group", methods={"POST"})
     */
    public function addUser($groupId, $name): JsonResponse
    {
        
         $group = $this->groupRepository->findOneBy(['id' => $groupId]);
        
         $user = $this->userRepository->findOneBy(['name' => $name]);
        
         $this->groupRepository->addUser($group, $user);

         return new JsonResponse(['status' => 'User added to the Group'], Response::HTTP_CREATED);
             
    }
    
      /**
     * @Route("/groups/{id}", name="get_group_users", methods={"GET"})
     */
    public function getGroupUsers($id): JsonResponse
    {
        
         $group = $this->groupRepository->findOneBy(['id' => $id]);
         
         $groups = $group->getUsers();

         return new JsonResponse($groups, Response::HTTP_CREATED);
    }
    
}
