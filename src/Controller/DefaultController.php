<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Tapa;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use \Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends AbstractController
{
    
    public function index(EntityManagerInterface $entityManager, $pagina=1) {
        $tapa = $entityManager->getRepository(Tapa::class);
        $tapas =$tapa->pageTapas($pagina);

        return $this->render('index.html.twig',['Tapas' => $tapas, 'paginaActual'=>$pagina]);
    }
    public function about() {
        return $this->render('about.html.twig');
    }
    public function bar($city='all'){
        return $this->render('bar.html.twig', array("city"=>$city));
    }

    public function tapaAction($id=null,ManagerRegistry $doctrine){
       if($id!=null){
            
        $Tapa = $doctrine-> getRepository(Tapa::class)-> find($id);
        if($Tapa){
            return $this->render('tapa.html.twig',array('Tapa'=>$Tapa));
        }else{
            return $this->redirectToRoute('index');
        } 
        }else{
            return $this->redirectToRoute('index');
        }
    }
    public function categoriaAction($id=null,ManagerRegistry $doctrine){
        if($id!=null){
             
         $Categoria = $doctrine-> getRepository(Categoria::class)-> find($id);
         if($Categoria){
             return $this->render('categoria.html.twig',array('categoria'=>$Categoria));
         }else{
             return $this->redirectToRoute('index');
         } 
         }else{
             return $this->redirectToRoute('index');
         }
     }
     public function ingredientAction($id=null,ManagerRegistry $doctrine){
        if($id!=null){
             
         $Ingredient = $doctrine-> getRepository(Ingredient::class)-> find($id);
         if($Ingredient){
             return $this->render('ingredient.html.twig',array('ingredient'=>$Ingredient));
         }else{
             return $this->redirectToRoute('index');
         } 
         }else{
             return $this->redirectToRoute('index');
         }
     }
     public function newUser(ManagerRegistry $doctrine,Request $request, UserPasswordHasherInterface $passwordEnconder ) {
        $em= $doctrine->getManager();
        $user = new User;
        $form_user = $this->createForm(\App\Form\UserType::class, $user);
        $form_user->handleRequest($request);
        if($form_user->isSubmitted() && $form_user->isValid()){
            $password = $passwordEnconder->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setUsername($user->getEmail());
            $user->setRoles(array('ROLE_USER'));
            $em->persist($user);
            $em->flush();
        return $this->redirectToRoute('loginAction', array('id'=> $user->getId()));
    }
        return $this->render('newUser.html.twig',[
            'form_user'=> $form_user->createView()
        ]);
    }

    public function loginAction(AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
          ]);

    
    }
    public function logout():void
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
    }
   

