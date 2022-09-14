<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    /**
     * @Route("admin/article/ajout", name="app_admin_article_ajout")
     */
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setActive(true);
            
            $imageArticle = $form->get('image')->getData();

            if($imageArticle){
                $originalFilename = pathinfo($imageArticle->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'-'.$imageArticle->guessExtension();

                try{
                    $imageArticle->move(
                        $this->getParameter('image'),
                        $newFilename
                    );
                }catch(FileException $e){

                }
                    $article->setImage($newFilename);
            }else{
                
            }

            $this->manager->persist($article);
            $this->manager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('article/ajout.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    // ----- TOUS LES ARTICLES -----
    /**
     * @Route("/all/articles", name="app_all_article")
     */
    public function allArticle(ArticleRepository $articleRepo): Response
    {
        // $article = $this->manager->getRepository(Article::class)->findAll();

        return $this->render('article/allArticle.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }

    // ----- SINGLE ARTICLE -----
    /**
     * @Route("/single/article/{id}", name="app_single_article")
     */
    public function single(Article $id): Response{
        $article = $this->manager->getRepository(Article::class)->find($id);

        return $this->render('article/single.html.twig', [
            'article' => $article,
        ]);
    }

    // ----- TOUS LES ARTICLES HISTOIRE -----
    /**
     * @Route("/article/histoire", name="app_article_histoire")
     */
    // public function allHistoire(): Response
    // {
    //     $article = $this->manager->getRepository(Article::class)->findAll();

    //     return $this->render('article/histoire/all.html.twig', [
    //         'article' => $article,
    //     ]);
    // }

    // ----- TOUS LES ARTICLES HISTOIRE NATURELLE -----
    /**
     * @Route("/article/histoire/histoire_naturelle", name="app_article_histoire_naturelle")
     */
    public function allNaturelle(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/histoire/histoireNaturelle.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => "DESC"]),
        ]);
    }

    // ----- TOUS LES ARTICLES ANTIQUITE -----
    /**
     * @Route("/article/histoire/antiquite", name="app_article_histoire_antiquite")
     */
    public function allAntiquite(): Response
    {
        $article = $this->manager->getRepository(Article::class)->findAll();

        return $this->render('article/histoire/antiquite.html.twig', [
            'article' => $article,
        ]);
    }

    // ----- TOUS LES ARTICLES MOYEN-ÂGE -----
    /**
     * @Route("/article/histoire/moyen_age", name="app_article_histoire_moyen")
     */
    public function allMoyen(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/histoire/moyenAge.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => "DESC"]),
        ]);
    }

    // ----- TOUS LES ARTICLES XVI - XVIII -----
    /**
     * @Route("/article/histoire/XVI_XVIII", name="app_article_xvi_xviii")
     */
    public function allXVI(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/histoire/xvi.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => "DESC"]),
        ]);
    }

    // ----- TOUS LES ARTICLES XIX - XX -----
    /**
     * @Route("/article/histoire/XIX_XX", name="app_article_xix_xx")
     */
    public function allXIX(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/histoire/xx.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => "DESC"]),
        ]);
    }







    // ----- TOUS LES ARTICLES ESPACE -----
    /**
     * @Route("/article/science/espace", name="app_article_science_espace")
     */
    public function allEspace(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/science/espace.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }

    // ----- TOUS LES ARTICLES SANTE -----
    /**
     * @Route("/article/science/sante", name="app_article_science_sante")
     */
    public function allSante(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/science/sante.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }

    // ----- TOUS LES ARTICLES TECHNOLOGIE -----
    /**
     * @Route("/article/science/technologie", name="app_article_science_tech")
     */
    public function allTech(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/science/technologie.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }

    // ----- TOUS LES ARTICLES VIVANT -----
    /**
     * @Route("/article/science/vivant", name="app_article_science_vivant")
     */
    public function allNature(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/science/vivant.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }

    
    
    // ----- TOUS LES ARTICLES ALIMENTATION -----
    /**
     * @Route("/article/societe/alimentation", name="app_article_societe_alimentation")
     */
    public function allAlimentation(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/societe/alimentation.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }

    // ----- TOUS LES ARTICLES FOLKLORE -----
    /**
     * @Route("/article/societe/folklore", name="app_article_societe_folklore")
     */
    public function allFolklore(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/societe/folklore.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }

    // ----- TOUS LES ARTICLES POPULATION -----
    /**
     * @Route("/article/societe/population", name="app_article_societe_population")
     */
    public function allPopulation(ArticleRepository $articleRepo): Response
    {
        return $this->render('article/societe/population.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }











    // ----- GESTION DES ARTICLES -----
    /**
     * @Route("/admin/all/articles", name="app_admin_all_articles")
     */
    public function admin(ArticleRepository $articleRepo): Response{

        return $this->render('article/gestion.html.twig', [
            'article' => $articleRepo->findBy(['active' => true], ['created_at' => 'DESC']),
        ]);
    }

    // ----- DELETE -----
    /**
     *@Route("admin/article/delete/{id}", name="app_article_delete")
     */
    public function articleDelete(Article $article): Response
    {
        $this->manager->remove($article);
        $this->manager->flush();

        return $this->redirectToRoute('app_admin_all_articles');
    }

    // ----- EDIT -----
    /**
     *@Route("admin/article/edit/{id}", name="app_admin_article_edit")
     */
    public function articleEdit(Article $article, Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setActive(true);
            $imageArticle = $form->get('image')->getData();
       
            if($imageArticle){
                $originalFilename = pathinfo($imageArticle->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageArticle->guessExtension();
                         
                    try {
                        $imageArticle->move(
                            $this->getParameter('image'),
                            $newFilename
                        );
                    }catch (FileException $e){
                
                    }
                
                    $article->setImage($newFilename);
                        
                }else{
                    // dd('aucune image disponible');
                };

            $this->manager->persist($article);
            $this->manager->flush();
            return $this->redirectToRoute('app_admin_all_articles');
        };

        return $this->render("article/edit.html.twig", [
            "articleForm" => $form->createView(),
        ]);
    }
}
