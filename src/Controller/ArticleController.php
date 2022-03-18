<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
  private $articleRepo;

  public function __construct(ManagerRegistry $registry)
  {
    $this->articleRepo = new ArticleRepository($registry);
  }

  /**
   * @Route(path="/", methods={"GET"}, name="article_list")
   */
  public function index()
  {
    $articles = $this->articleRepo->findAll();

    return $this->render("articles/index.html.twig", ['articles' => $articles]);
  }

  /**
   * @Route(path="/article/create", methods={"GET", "POST"}, name="create_article")
   */
  public function create(Request $request)
  {
    $article = new Article();

    $form = $this->createFormBuilder($article)
      ->add('title', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
      ->add('body', TextareaType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
      ->add('submit', SubmitType::class, ['label' => 'Create', 'attr' => ['class' => 'btn btn-primary mt-3']])
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $article = $form->getData();

      $this->articleRepo->add($article);

      return $this->redirectToRoute('article_list');
    }

    return $this->render('articles/create.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route(path="/article/{id}/edit", methods={"GET", "POST"}, name="edit_article")
   */
  public function edit(Request $request, $id)
  {
    $article = $this->articleRepo->find($id);

    if (!$article) {
      return (new Response())->setStatusCode(404)->send();
    }

    $form = $this->createFormBuilder($article)
      ->add('title', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
      ->add('body', TextareaType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
      ->add('submit', SubmitType::class, ['label' => 'Update', 'attr' => ['class' => 'btn btn-primary mt-3']])
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->articleRepo->update($article);

      return $this->redirectToRoute('article_list');
    }

    return $this->render('articles/edit.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route(path="/article/{id}", methods={"GET"}, name="article_show")
   */
  public function show($id)
  {
    $article = $this->articleRepo->find($id);

    if (!$article) {
      return (new Response())->setStatusCode(404)->send();
    }

    return $this->render('articles/show.html.twig', ['article' => $article]);
  }

  /**
   * @Route(path="/article/{id}/delete", methods={"DELETE"}, name="article_delete")
   */
  public function destroy($id)
  {
    $article = $this->articleRepo->find($id);
    $response = new Response();

    if (!$article) {
      return $response->setStatusCode(404)->send();
    }

    $this->articleRepo->remove($article);

    return $response->send();
  }

  /**
   * @Route(path="/article/save", methods={"GET"})
   */
  public function save()
  {
    $article = (new Article())->setArticleProps('Simon Sinek', 'Understand your people');

    // $this->articleRepo->add($article);

    return new Response('Saves article ' . $article->getId());
  }
}