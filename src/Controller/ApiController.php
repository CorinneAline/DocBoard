<?php


namespace DocBoard\Controller;


use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

use DocBoard\Domain\Article;


class ApiController {


    /**
     * API articles controller.
     *
     * @param Application $app Silex application
     *
     * @return All articles in JSON format
     */
    public function getArticlesAction(Application $app) {

        $articles = $app['dao.article']->findAll();
        // Convert an array of objects ($articles) into an array of associative arrays ($responseData)
        $responseData = array();

        foreach ($articles as $article) {
            $responseData[] = $this->buildArticleArray($article);
        }

        // Create and return a JSON response
        return $app->json($responseData);

    }


    /**
     * API article details controller.
     *
     * @param integer $id Article id
     * @param Application $app Silex application
     *
     * @return Article details in JSON format
     */
    public function getArticleAction($id, Application $app) {

        $article = $app['dao.article']->find($id);
        $responseData = $this->buildArticleArray($article);

        // Create and return a JSON response
        return $app->json($responseData);

    }


    /**
     * API create article controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     *
     * @return Article details in JSON format
     */
    public function addArticleAction(Request $request, Application $app) {

        // Check request parameters
        if (!$request->request->has('title')) {
            return $app->json('Missing required parameter: title', 400);
        }

        if (!$request->request->has('content')) {
            return $app->json('Missing required parameter: content', 400);
        }

        // Build and save the new article
        $article = new Article();
        $article->setTitle($request->request->get('title'));
        $article->setContent($request->request->get('content'));
        $app['dao.article']->save($article);
        $responseData = $this->buildArticleArray($article);
        
        return $app->json($responseData, 201);  // 201 = Created

    }


    /**
     * API delete article controller.
     *
     * @param integer $id Article id
     * @param Application $app Silex application
     */
    public function deleteArticleAction($id, Application $app) {

        // Delete all associated comments
        $app['dao.comment']->deleteAllByArticle($id);
        // Delete the article
        $app['dao.article']->delete($id);

        return $app->json('No Content', 204);  // 204 = No content

    }


    /**
     * Converts an Article object into an associative array for JSON encoding
     *
     * @param Article $article Article object
     *
     * @return array Associative array whose fields are the article properties.
     */
    private function buildArticleArray(Article $article) {

        $data  = array(
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
            );

        return $data;
        
    }
    
    
    /**
     * API links controller.
     *
     * @param Application $app Silex application
     *
     * @return All links in JSON format
     */

    public function getLinksAction(Application $app) {

        $links = $app['dao.link']->findAll();

        // Convert an array of objects ($links) into an array of associative arrays ($responseData)
        $responseData = array();
        
        foreach ($links as $link) {
            $responseData[] = $this->buildLinkArray($link);
        }

        // Create and return a JSON response
        return $app->json($responseData);

    }


    /**
     * API link details controller.
     *
     * @param integer $id Link id
     * @param Application $app Silex application
     *
     * @return Link details in JSON format
     */

    public function getLinkAction($id, Application $app) {

        $link = $app['dao.link']->find($id);
        $responseData = $this->buildLinkArray($link);

        // Create and return a JSON response
        return $app->json($responseData);

    }

    /**
     * Converts a Link object into an associative array for JSON encoding
     *
     * @param Link $link Link object
     *
     * @return array Associative array whose fields are the link properties.
     */

    private function buildLinkArray(Link $link) {

        $data  = array(
            'id' => $link->getId(),
            'title' => $link->getTitle(),
            'url' => $link->getUrl()
            );

        return $data;

    }

}
