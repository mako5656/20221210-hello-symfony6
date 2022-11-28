<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
        $person->setName('山田太郎')
            ->setAge(25)
            ->setMail('yamada.taro@sample.com');

        $form = $this->createFormBuilder($person)
            ->add('name', TextType::class)
            ->add('age', IntegerType::class)
            ->add('mail', EmailType::class)
            ->add('save', SubmitType::class, ['label' => 'Click'])
            ->getForm();

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            $obj = $form->getData();
            $message = '名前: ' . $obj->getName() . '<br>'
                . '年齢: ' . $obj->getAge() . '<br>'
                . 'メールアドレス: ' . $obj->getMail();
        } else {
            $message = 'こんにちは！';
        }
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello World!',
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }
}
