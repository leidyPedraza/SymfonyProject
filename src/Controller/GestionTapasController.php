<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Tapa;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

class GestionTapasController extends AbstractController
{
    public function newTapa(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger) {
        $em= $doctrine->getManager();
        $tapa = new Tapa;
        $form_tapa = $this->createForm(\App\Form\NewTapaType::class, $tapa);
        
        $form_tapa->handleRequest($request);
        if($form_tapa->isSubmitted() && $form_tapa->isValid()){

        $fotoFile = $form_tapa->get('foto')->getData();
        $originalFileName = pathinfo($fotoFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFileName);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$fotoFile->guessExtension();
        
        $fotoFile->move( $this->getParameter('tapaImg_directory'),$newFilename );
        $tapa->setFoto($newFilename);
        $em->persist($tapa);
        $em->flush();
        return $this->redirectToRoute('tapaAction', array('id'=> $tapa->getId()));
    }
        return $this->render('newTapa.html.twig',[
            'form_tapa'=> $form_tapa->createView()
        ]);
    }

    public function newCategory(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger){
        $em= $doctrine->getManager();
        $categoria = new Categoria;
        $form_categoria = $this->createForm(\App\Form\NewCategoryType::class, $categoria);
        
        $form_categoria->handleRequest($request);
        if($form_categoria->isSubmitted() && $form_categoria->isValid()){

        $fotoFile = $form_categoria->get('foto')->getData();
        $originalFileName = pathinfo($fotoFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFileName);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$fotoFile->guessExtension();
        
        $fotoFile->move( $this->getParameter('tapaImg_directory'),$newFilename );
        $categoria->setFoto($newFilename);
        $em->persist($categoria);
        $em->flush();
        return $this->redirectToRoute('categoriaAction', array('id'=> $categoria->getId()));
    }
        return $this->render('newCategoria.html.twig',[
            'form_categoria'=> $form_categoria->createView()
        ]);
    }

    public function newIngredient(ManagerRegistry $doctrine, Request $request){
        $em= $doctrine->getManager();
        $ingredient = new Ingredient;
        $form_ingredient = $this->createForm(\App\Form\IngredientType::class, $ingredient);
        
        $form_ingredient->handleRequest($request);
        if($form_ingredient->isSubmitted() && $form_ingredient->isValid()){
        $em->persist($ingredient);
        $em->flush();
        return $this->redirectToRoute('ingredientAction', array('id'=> $ingredient->getId()));
    }
        return $this->render('newIngredient.html.twig',[
            'form_ingredient'=> $form_ingredient->createView()
        ]);
    }
}

