<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function index(UserRepository $users)
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * Permet de supprimer un utilisateur
     *
     * @Route("/admin/user/{id}/delete",name="admin_user_delete")
     * 
     * @param ObjectManager $manager
     * @param User $user
     * @return Response
     */
    public function delete(ObjectManager $manager, User $user){
        $manager->remove($user);
        $manager->flush();
        return redirectToRoute('admin_users');
    }
}
