Snowyday
========

Documentation Rest, FOSUser, FOSRestBundle et pas mal d'autres infos
https://zestedesavoir.com/tutoriels/1280/creez-une-api-rest-avec-symfony-3/amelioration-de-lapi-rest/securisation-de-lapi-2-2/

Documentation Rest, FOSUser, FOSRestBundle, FosAuth et pas mal d'autres infos un peu tricky.
https://bitgandtter.blog/2015/09/03/symfony-a-restful-app-motivation/
Symfony commands
****************
Vide le cache
php bin/console cache:clear --no-warmup --env=dev

Affiche le paramétrage correspondant à FOS_REST
php bin/console debug:config fos_rest

Creation d'un utilisateur fos_user
php bin/console fos:user:create

Creation de la table correspondant à la classe dans entity
php bin/console doctrine:schema:update --force

php bin/console debug:router

Fichiers modifiés
*****************

//web/app_dev.php
//src/SD/AppserverloginBundle/Resources/views/Default/index.html.twig
//app/AppKernel.php
//app/config/config.yml 
//src/SD/AppserverloginBundle/Entity/User.php
//src/SD/AppserverloginBundle/User/User.php
//app/config/security.yml
//app/config/routing.yml
//app/config/parameters.yml
//src\SD\AppserverloginBundle\Controller\UserController.php
// src\SD/AppserverloginBundle/Form/Type/UserType.php

composer.json

CLOUD9-PHP7
***********
Par defaut sur cloud9 on est dans une version 5.x de PHP  ::

 php -v

pour se positionner en version 7 faire les commandes ci-dessous. Après ces commandes on n'aura plus accés à PHPMYADMIN.
Tester la commande suivante pour rétablir phpmyadmin  phpmyadmin-ctl install mais pour l'instant cela n'a pas marché cela m'a rajouté une ligne d'erreur dans la config apache donc pour l'instant ne pas faire.
Je n'ai pas encore réussi à le réinstaller. ::

 sudo add-apt-repository ppa:ondrej/php
 sudo apt-get update
 sudo apt-get -y purge php5 libapache2-mod-php5 php5 php5-cli php5-common php5-curl php5-gd php5-imap php5-intl php5-json php5-mcrypt php5-mysql php5-pspell php5-readline php5-sqlite
 sudo apt-get autoremove
 sudo apt-get install php
 
 /* A priori ne plus faire cette commande mais celle ci-dessous sudo apt-get install php7.0-mysql  */
  sudo apt-get install php-mysql
Pour tester si le driver de mysql est bien installé on peut faire la commande ::

 php -m | grep pdo

/* j'ai aussi trouvé la commande ci-dessous qui semble installer plus de package utile ou pas je ne sais pas encore a priori plus complete j'ai eu une erreur sur le serveur symfony sur Xmlutil qui a été résolu avec la commande ci-dessous  */ 
 sudo apt-get install php-curl php-cli php-dev php-gd php-intl php-mcrypt php-json php-mysql php7.0-opcache php-bcmath php-mbstring php-soap php-xml php-zip -y

 
 MySQl
 *****
 
 mysql-ctl start
 
Ajout de l'utilisateur manu comme super utilisateur ::
 
 mysql -u root

 GRANT ALL PRIVILEGES ON *.* TO manu@localhost
      IDENTIFIED BY 'xevrod2x' WITH GRANT OPTION;

Composer
********

pour installer composer je vais à l'adresse ci-dessous et je copie-colle les commandes dans une console.

https://getcomposer.org/download/


symfony
*******
On récupére le script symfony ::

 php -r "readfile('https://symfony.com/installer');" > symfony

On lance l'installation du projet (peu importe le nom du projet on va le redéplacer à la racine par la suite) ::

 php symfony new api.snowyday.org
 
 
Déplacer le projet créé à la racine ::
 
 mv api.snowyday.org/{,.} ./ 
 rm -rf api.snowyday.org 
 
Il faut ensuite supprimer les lignes ci-dessous sinon on obtient une erreure en allant sur le site ::

 //web/app_dev.php
 // This check prevents access to debug front controllers that are deployed by accident to production servers.
 // Feel free to remove this, extend it, or make something more sophisticated.
 if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || php_sapi_name() === 'cli-server')
 ) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
 }
 
 
Configuration de la base de données dans le fichier app/config/parameters.yml ::

créer la base de donnée définit dans le fichier.
se connecter à mysql ::
 mysql -u manu -p

puis create database snowyday CHARACTER SET 'utf8';


On peut ensuite se rendre à l'adresse ci-dessous pour vérifier que tout fonctionne normalement
https://snowyday-man.c9users.io/web/app_dev.php

Bundle symfony
**************

Je vais maintenant créer un bundle afin de le réutiliser dans d'autres projets.
Je vais créer un bundle de login de clients 

php bin/console generate:bundle

Je reponds "yes" à la question de réutilisation du bundle puisque c'est évidement mon but
Bundle namesapce:  SD/AppuserclientBundle
Bundle name: Enter  (on laisse le defaut)
target Directory : Enter (on laisse le defaut)
Configuration format (annotation, yml, xml, php) [xml]: yml

Aprés ça le lien ci dessous pointe vers notre bundle et on perdu la barre du bas de deboguage.
https://snowyday-man.c9users.io/web/app_dev.php
Symfony rajoute cette barre à chaque page contenant les balises <Body>.
On va donc modifier le fichier ci-dessous pour la récupérer.

{# src/SD/AppuserclientBundle/Resources/views/Default/index.html.twig #}

<html>
  <body>
    Hello World!
  </body>
</html>

Ajout GITHUB
************

Créer un nouveau repository sur GITHUB, noter le lien vers ce nouveau repository https://github.com/Mouchy/snowyday.git

Puis initialiser git sur cloud9 pour pointer sur le repository github, dans une console cloud9 ::

 git init
 git remote add origin https://github.com/Mouchy/snowyday.git

Voila pas besoin de plus il faut maintenant ajouter des fichiers dans notrerepository local puis les commiter en local ::

 git add README.md
 git commit -m "Test pour la mise en place de GIT"

Ensuite on va synchroniser notre repository local avec celui de github ::

 git push -u origin master
 

FOSRestBundle
*************

Pour un projet rest complet 
https://zestedesavoir.com/tutoriels/1280/creez-une-api-rest-avec-symfony-3/un-tour-dhorizon-des-concepts-rest/#1-rest-en-quelques-mots
https://bitgandtter.blog/2015/09/04/symfony-a-restful-app-rest-levels-0-1-2-fosrestbundle-jmsserializerbundle/

On peut trouver des exemples sur le fonctionnement rest avec symfony avec le projet ci-dessous. 
C'est un projet pret à télécharger avec un exemple 
https://github.com/gimler/symfony-rest-edition

Download the Bundle ::

 php composer.phar require friendsofsymfony/rest-bundle

Enable the Bundle ::

 // app/AppKernel.php
 class AppKernel extends Kernel
 {
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new FOS\RestBundle\FOSRestBundle(),
        );

        // ...
    }
 }

Configuration ::


 app/config/config.yml 

 sensio_framework_extra:
     view:   { annotations: true }
     router: { annotations: true }

 fos_rest:
     param_fetcher_listener: true
     body_listener: true
     disable_csrf_role: ROLE_API
     allowed_methods_listener: true
     unauthorized_challenge: "Basic realm=\"Restricted Area\""
     access_denied_listener:
         json: true
         xml: true
         html: true
     view:
         view_response_listener: 'force'
         force_redirects:
             html: true
         formats:
             json: true
             xml: true
     format_listener:
         rules:
             - { path: ^/, priorities: [ json, xml ], fallback_format: json, prefer_extension: true}


Le parametre **body_listener** intercepte toutes les requêtes pour les faire passer par rest on aura ainsi plus aucune page générer en HTML


Pour vérifier la configuration de fos_restbundle on peut utiliser la commande ::

 php bin/console debug:config fos_res

JMSSerializerBundle
*******************

Lors de l'installation de ce bundle j'ai eu une erreur. Pour la corriger j'ai décommenté la ligne du fichier app/config/config.yml ::

 serializer:      { enable_annotations: true }

Download the Bundle ::

 php composer.phar require jms/serializer-bundle

Enable the Bundle ::
 
 // app/AppKernel.php
 $bundles = array(
    // ...
    new JMS\SerializerBundle\JMSSerializerBundle(),
    // ... 
 );


FOSUserBundle
*************

http://symfony.com/doc/master/bundles/FOSUserBundle/index.html

Download the Bundle ::

php composer.phar require friendsofsymfony/user-bundle "~2.0"

Enable the Bundle ::

 // app/AppKernel.php
 class AppKernel extends Kernel
 {
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new FOS\UserBundle\FOSUserBundle(),
        );

        // ...
    }
 }
 
 
 Entity class
 
 
 <?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}

Security.yml

# app/config/security.yml
security:
    encoders:
        FOS\UserBundle\Model\UserInterface: bcrypt

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN

    providers:
        fos_userbundle:
            id: fos_user.user_provider.username

    firewalls:
        main:
            pattern: ^/
            form_login:
                provider: fos_userbundle
                csrf_token_generator: security.csrf.token_manager
                # if you are using Symfony < 2.8, use the following config instead:
                # csrf_provider: form.csrf_provider

            logout:       true
            anonymous:    true

    access_control:
        - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin/, role: ROLE_ADMIN }


Configuration

//app/config/config.yml

fos_user:
    db_driver: orm
    firewall_name: main
    user_class: SD\AppsnowydayBundle\Entity\User
    from_email:
        address: "NONE"
        sender_name: "NONE"
        
Routes

//app/config/routing.yml
users:
    type: rest
    resource: SD\AppsnowydayBundle\Controller\UserController

Test route ::
php bin/console debug:router

Mettre à jour la base de donnée avec la classe entité défini plus haut

php bin/console doctrine:schema:update --force


Namespace User
**************

On rajoute un nouveau namespace User avec une classe User

<?php
//src/SD/AppsnowydayBundle/User
namespace User;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

   
    /**
     * User constructor.
     * @param $id
     */
    public function __construct()
    {
        echo("Customer constructor");
        $this->id = $this->id ? $this->id : uniqid();
        parent::__construct();
    }
    
    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

}

On doit déclarer ce nouveau namespace afin qu'il soit vu dans les autres classe.
Depuis la version 3.3 de symfony il n'y a plus de fichier /app/autoload.php
On utilise maintenant composer. On modifie le fichier composer.json comme ci-dessous.
J'ai rajouté la ligne avec le user ::

 "autoload": {
        "psr-4": {
            "AppBundle\\": "src/AppBundle",
            "User\\": "src/SD/AppsnowydayBundle/User"

Puis on tape la commande ::

 composer dump-autoload
 ou sous windows
 php composer.phar dump-autoload


UserController
**************

On va maintenant mettre en place notre controller. On crée un fichier UserController.php et le fichier Form/UserType.php

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


<?php
// src/AppserverloginBundle/Form/Type/UserType.php
namespace SD\AppserverloginBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
            ->add('username', TextareaType::class)
            ->add('email', TextareaType::class)
            ->add('password',  TextareaType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SD\AppserverloginBundle\Entity\User',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}

On doit déclarer ce nouveau namespace afin qu'il soit vu dans les autres classe.
Depuis la version 3.3 de symfony il n'y a plus de fichier /app/autoload.php
On utilise maintenant composer. On modifie le fichier composer.json comme ci-dessous.
J'ai rajouté la ligne avec le Usertype ::

 "autoload": {
        "psr-4": {
            "AppBundle\\": "src/AppBundle",::
            "SD\\AppsnowydayBundle\\Form\\": "src/SD/AppsnowydayBundle/Form"

Puis on tape la commande ::

 composer dump-autoload
 ou sous windows
 php composer.phar dump-autoload
 
Pour faire un Post des données on utilise la ligne ci-dessous. Je n'ai pas encore compris pourquoi on rajoute un s à users à la fin de la ligne.
Le password est en claire dans la base pour l'instant. Peut etre parceque je n'ai pas encore typé les champs dans le formulaire (UserType.php).
Il faut soit que je type le champ comme ci-dessous mais cette façon de faire est peut etre obsolete j'obtient un message d'erreur

 $builder
            ->add('username', 'text')
            ->add('email', 'email')
            ->add('password', 'password');

Sinon je dois déclarer les champs dans un fichier AppuserBundle/Resources/config/validation.yml

curl -v -X POST -H "Content-Type: application/json" -d '{"user":{"username": "yasmany","email": "yasmanycm@gmail.com","password": "ok"}}' https://snowyday2-man.c9users.io/web/app_dev.php/users > test.html

Swagger UI
**********

Je n'ai pour l'instant pas utilisé ce bundle
Installation de Swagger UI

Si vous utilisez git, il suffit de se placer dans le dossier web et de lancer ::

 git clone https://github.com/swagger-api/swagger-ui.git
 
Si l’installation s’est bien déroulée, en accédant à l’URL  https://snowyday-man.c9users.io/web/swagger-ui/dist/index.html, la page d’accueil de Swagger UI s’affiche.

NelmioApiDocBundle
******************
Je n'ai pour l'instant pas utilisé ce bundle


composer require nelmio/api-doc-bundles








