<?php
//SD\AppserverloginBundle\Controller\UserController.php

namespace SD\AppserverloginBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRestBundleAnnotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use SD\AppserverloginBundle\Entity\User;
use SD\AppserverloginBundle\Form\UserType;


/**
 * @FOSRestBundleAnnotations\View()
 */
class UserController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction()
    {
        /***************************************************************************************************************************/
        /* Recupération de tous les utilisateurs de la base                                                                        */
        /* curl -X GET -H "Accept:application/json" https://snowyday-man.c9users.io/web/app_dev.php/users                          */
        /* avec formatage json                                                                                                     */
        /* curl -X GET -H "Accept:application/json" https://snowyday-man.c9users.io/web/app_dev.php/locations | python -mjson.tool */
        /***************************************************************************************************************************/
        echo("UsersController::cgetAction");
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository("SDAppserverloginBundle:User");
        $users = $repository->findAll();
        return $users;
    }
    
    
    public function getAction(User $user)
    {
        return $user;
    }
    
    /************************************************************************************************************************************************************************************************************/
    /* Creation d'un nouvel utilisateur dans la base de données                                                                                                                                                 */
    /* curl -v -X POST -H "Content-Type: application/json" -d '{"customer":{"username": "yasmany","email": "yasmanycm@gmail.com","password": "ok"}}' https://snowyday-man.c9users.io/web/app_dev.php/users      */
    /* customer est le nom de la form et le reste les noms des champs                                                                                                                                           */
    /* la fonction handleRequest essaie de merger les données reçue ($request) avec la form $userForm                                                                                                           */
    /* isSubmitted vérifie que les données viennent bien de l'appuie du bouton submit de la form généré. Normalement on rentre une premiére fois dans la fonction postAction on génére le formulaire à l'écran  */
    /* Puis ensuite l'utilisateur remplit les champs et valide sa saisie avec le bouton submit et on retourne une nouvelle fois dans la fonction postAction pour valider les données                            */
    /* La fonction isValid valide les contraintes sur les données si il y en a (dans notre cas il n'y en a pas)                                                                                                 */
    /************************************************************************************************************************************************************************************************************/
    public function postAction(Request $request)
    {
      
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
      
        $userForm->handleRequest($request);
      
        if ($userForm->isSubmitted()) {
            echo "isSubmitted";
        }

        if ($userForm->isValid()) {
            echo "isvalid";
            $em = $this->getDoctrine()->getEntityManager();
            print_r($user);
            $em->persist($user);
            $em->flush();
            return $user;
        }
        echo "Isnt valid";
      
        return $userForm->getErrors();
    }
}
