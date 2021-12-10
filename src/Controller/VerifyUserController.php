<?php

namespace App\Controller;

use App\Repository\CodeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Twilio\Rest\Client;

class VerifyUserController extends AbstractController
{

    /**
     * @Route("/api/verify-user", name="verify_user")
     */
    public function verifyUuser(Request $request, UserRepository $repo, EntityManagerInterface $em): Response
    {

        $data = \json_decode($request->getContent(), true);
        if (!isset($data["tel"])) {
            return $this->json([
                'message' => 'Numero de telephone est obligatoire',
            ], 204);    
        }

        $user = $repo->findOneByTel($data["tel"]);
        if ($user === null) {
            return $this->json([
                'message' => 'Numero de telephone est incorecte ou n\'a pas de compte',
            ], 404);
        }

        $code = new Code();
        $code->setUser($user);
        $code->setCode($this->genereCode());
        $em->persist($code);
        $em->flush();
        
        // Use twillo to send sms user
        return $this->json([
            'message' => 'Numero de telephone valide veuillez renvoyer le code reçu par sms',
        ], 200);
    }

    /**
     * @Route("/api/verify-code-client", name="verify_secret_code", methods={"POST"})
     */
    public function verifySecretCode(Request $request, CodeRepository $rpcode, EntityManagerInterface $em): Response
    {
        $data = \json_decode($request->getContent(), true);
        if (!isset($data["code"])) {
            return $this->json([
                'message' => 'Le code d\activation est obligatoire',
            ], 204);    
        }
        $result = $rpcode->findOneByCode($data["code"]);
        if ($result === null) {
            return $this->json([
                'message' => 'Code invalide',
            ], 404);
        }
        // $em->remove($result);
        // $em->flush();
        return $this->json([
            'message' => 'succes',
            'data' => $result->getUser()->setPassword('')
        ], 200);
    }

    public function genereCode($longueur=4) {
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        $chaineAleatoire = '';
        for ($i = 0; $i < $longueur; $i++)
        {
            $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
        }
        return $chaineAleatoire;
    }
    
     public function sendSms($msg, $numclient)
     {
         $sid ='AC29e929410461366971eb1450da975956';
        $token = 'ee7b46acb982af50b0cf188f70792233';
        $num1= "(909) 443-1322";
        $my_num = '+19094431322';
        
        $client = new Client($sid, $token);
        
        $message = $client->messages->create(
             '+221'.$numclient, // Text this number
            [
              'from' => $my_num, // From a valid Twilio number
               'body' => $msg
             ]
           );
        
           if ($message->sid) {
             return "oki";
          }
         return "non oki";
     }
}