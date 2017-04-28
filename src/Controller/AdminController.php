<?php


namespace DocBoard\Controller;


use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

use DocBoard\Domain\Article;
use DocBoard\Domain\User;
use DocBoard\Form\Type\ArticleType;
use DocBoard\Form\Type\CommentType;
use DocBoard\Form\Type\UserType;
use DocBoard\Domain\Link;
use DocBoard\Form\Type\LinkType;


class AdminController {

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {

        $articles = $app['dao.article']->findAll();
        $comments = $app['dao.comment']->findAll();
        $users = $app['dao.user']->findAll();
        $links = $app['dao.link']->findAll();
        
        return $app['twig']->render('admin.html.twig', array(
                'articles' => $articles,
                'comments' => $comments,
                'users'  => $users,
                'links' => $links ));

    }
    
    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function adminCmsAction(Application $app) {

        $articles = $app['dao.article']->findAll();
        $comments = $app['dao.comment']->findAll();
        $users = $app['dao.user']->findAll();

        return $app['twig']->render('admin_cms.html.twig', array(
            'articles' => $articles,
            'comments' => $comments,
            'users' => $users));
    }


    /**
     * Add article controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addArticleAction(Request $request, Application $app) {

        $article = new Article();
        $articleForm = $app['form.factory']->create(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $app['dao.article']->save($article);
            $app['session']->getFlashBag()->add('success', 'The article was successfully created.');

        }

        return $app['twig']->render('article_form.html.twig', array(
            'title' => 'New article',
            'articleForm' => $articleForm->createView()));

    }


    /**
     * Edit article controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editArticleAction($id, Request $request, Application $app) {

        $article = $app['dao.article']->find($id);
        $articleForm = $app['form.factory']->create(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $app['dao.article']->save($article);
            $app['session']->getFlashBag()->add('success', 'The article was successfully updated.');

        }

        return $app['twig']->render('article_form.html.twig', array(
            'title' => 'Edit article',
            'articleForm' => $articleForm->createView()));

    }


    /**
     * Delete article controller.
     *
     * @param integer $id Article id
     * @param Application $app Silex application
     */

    public function deleteArticleAction($id, Application $app) {

        // Delete all associated comments
        $app['dao.comment']->deleteAllByArticle($id);
        // Delete the article
        $app['dao.article']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The article was successfully removed.');
        
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin_cms'));

    }


    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editCommentAction($id, Request $request, Application $app) {

        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'The comment was successfully updated.');
        }

        return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Edit comment',
            'commentForm' => $commentForm->createView()));

    }


    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentAction($id, Application $app) {

        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The comment was successfully removed.');

        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin_cms'));

    }
    
    
     /**
     * Add link controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */

    public function addLinkAction(Request $request, Application $app) {

        $link = new Link();        
        $user = $app['user'];
        $link->setAuthor($user);       
        $linkForm = $app['form.factory']->create(LinkType::class, $link);
        $linkForm->handleRequest($request);

        if ($linkForm->isSubmitted() && $linkForm->isValid()) {
            $app['dao.link']->save($link);
            $app['session']->getFlashBag()->add('success', 'The link was successfully created.');
            return $app->redirect($app['url_generator']->generate('links'));
        }

        return $app['twig']->render('link_form.html.twig', array(
            'title' => 'New link',
            'linkForm' => $linkForm->createView()));

    }
    
    /**
     * Edit link controller.
     *
     * @param integer $id Link id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */

    public function editLinkAction($id, Request $request, Application $app) {

        $link = $app['dao.link']->find($id);
        $linkForm = $app['form.factory']->create(LinkType::class, $link);
        $linkForm->handleRequest($request);
        
        if ($linkForm->isSubmitted() && $linkForm->isValid()) {
            $app['dao.link']->save($link);
            $app['session']->getFlashBag()->add('success', 'The link was successfully updated.');
        }

        return $app['twig']->render('link_form.html.twig', array(
            'title' => 'Edit link',
            'linkForm' => $linkForm->createView()));
    }


    /**
     * Delete link controller.
     *
     * @param integer $id Link id
     * @param Application $app Silex application
     */

    public function deleteLinkAction($id, Application $app) {

        $app['dao.link']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The link was successfully removed.');

        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));

    }


    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */

    public function addUserAction(Request $request, Application $app) {
    
        $user = new User();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();

            // find the default encoder
            $encoder = $app['security.encoder.bcrypt'];

            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());

            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
        }

        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'New user',
            'userForm' => $userForm->createView()));

    }


    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app) {

        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password

            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully updated.');

        }

        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'Edit user',
            'userForm' => $userForm->createView()));

    }


    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {

        // Delete all associated comments
        $app['dao.comment']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was successfully removed.');

        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));

    }

}