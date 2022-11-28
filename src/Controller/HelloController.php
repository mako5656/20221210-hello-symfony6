<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name:'hello')]
    public function index(Request $request): Response
    {
        $person = new Person();

        $form = $this->createFormBuilder($person)
            ->add('name', TextType::class)
            ->add('mail', EmailType::class)
            ->add('save', SubmitType::class, ['label' => 'Click'])
            ->getForm();

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            $obj = $form->getData();
            $message = '名前は' . $obj->getName() . 'で、' . 'メールアドレスは ' . $obj->getMail() . 'です。';
        } else {
            $message = 'こんにちは！<br>あなたの名前とメールアドレスを教えて下さい！';
        }

        return $this->render('hello/index.html.twig', [
            'title' => 'Hello World!',
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }
}
