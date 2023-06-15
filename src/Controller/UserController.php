<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: "/user")]
class UserController extends AbstractController
{
    public function __construct(
        public UserRepository $userRepository,
    )
    {
    }


    /**
     * @throws \Exception
     */
    #[Route(path: "/registration", methods: ["POST"])]
    public function create(Request                     $request,
                           LoggerInterface             $logger,
                           MailerInterface             $mailer,
                           SerializerInterface         $serializer,
                           ValidatorInterface          $validator,
                           UserPasswordHasherInterface $passwordHasher
    ): Response
    {

        $user = $serializer->deserialize($request->getContent(), User::class, format: 'json');

        $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            return new Response($errorsString);

        } else {

            $this->userRepository->save($user, true);

            $logger->info("Response to save new user");

            $response = ($serializer->serialize($user, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]));

            return new Response($response);
        }
    }

    #[Route(path: "/{id}")]
    public function show(Request $request, LoggerInterface $logger, SerializerInterface $serializer): Response
    {

//        $logger->info("Response to get user by id:" . $user->id);
        $user = $this->userRepository->find($request->get('id'));
        $response = ($serializer->serialize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }]));
        return new Response($response);
    }

    #[Route(path: "/")]
    public function showAll(Request $request, LoggerInterface $logger, SerializerInterface $serializer): Response
    {

//        $logger->info("Response to get user by id:" . $user->id);
        $user = $this->userRepository->findAll();
        $response = ($serializer->serialize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }]));
        return new Response($response);
    }


}