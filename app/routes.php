<?php

// Home page
$app->get('/', "DocBoard\Controller\HomeController::indexAction")
->bind('home');

// Article page
$app->get('/cms', "DocBoard\Controller\HomeController::cmsAction")
->bind('cms');

// Link page
$app->get('/links', "DocBoard\Controller\HomeController::linksAction")
->bind('links');

// Detailed info about an article
$app->match('/article/{id}', "DocBoard\Controller\HomeController::articleAction")
->bind('article');

// Login form
$app->get('/login', "DocBoard\Controller\HomeController::loginAction")
->bind('login');

// Admin zone
$app->get('/admin', "DocBoard\Controller\AdminController::indexAction")
->bind('admin');

// Admin zone
$app->get('/admin/cms', "DocBoard\Controller\AdminController::adminCmsAction")
->bind('admin_cms');

// Add a new article
$app->match('/admin/article/add', "DocBoard\Controller\AdminController::addArticleAction")
->bind('admin_article_add');

// Edit an existing article
$app->match('/admin/article/{id}/edit', "DocBoard\Controller\AdminController::editArticleAction")
->bind('admin_article_edit');

// Remove an article
$app->get('/admin/article/{id}/delete', "DocBoard\Controller\AdminController::deleteArticleAction")
->bind('admin_article_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', "DocBoard\Controller\AdminController::editCommentAction")
->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', "DocBoard\Controller\AdminController::deleteCommentAction")
->bind('admin_comment_delete');

// Add a user
$app->match('/admin/user/add', "DocBoard\Controller\AdminController::addUserAction")
->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', "DocBoard\Controller\AdminController::editUserAction")
->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', "DocBoard\Controller\AdminController::deleteUserAction")
->bind('admin_user_delete');

// API : get all articles
$app->get('/api/articles', "DocBoard\Controller\ApiController::getArticlesAction")
->bind('api_articles');

// API : get an article
$app->get('/api/article/{id}', "DocBoard\Controller\ApiController::getArticleAction")
->bind('api_article');

// API : create an article
$app->post('/api/article', "DocBoard\Controller\ApiController::addArticleAction")
->bind('api_article_add');

// API : remove an article
$app->delete('/api/article/{id}', "DocBoard\Controller\ApiController::deleteArticleAction")
->bind('api_article_delete');

// Add a link
$app->match('admin/link/submit', "DocBoard\Controller\AdminController::addLinkAction")
->bind('link_submit');

// Edit an existing link
$app->match('/admin/link/{id}/edit', "DocBoard\Controller\AdminController::editLinkAction")
->bind('admin_link_edit');

// Remove a link
$app->get('/admin/link/{id}/delete', "DocBoard\Controller\AdminController::deleteLinkAction")
->bind('admin_link_delete');

// API : get all links
$app->get('/api/links', "DocBoard\Controller\ApiController::getLinksAction")
->bind('api_links');

// API : get an link
$app->get('/api/link/{id}', "DocBoard\Controller\ApiController::getLinkAction")
->bind('api_link');


// Books - other kind without controller

$app->get('/books', function () use ($app) {
    $books = $app['dao.book']->findAll();
    return $app['twig']->render('books.html.twig', array('books' => $books));
})->bind('books');

$app->get('/book/{id}', function ($id) use ($app) {
    $book = $app['dao.book']->find($id);
    $author = $app['dao.author']->find($book->getAuthor()->getId());
    return $app['twig']->render('book.html.twig', array('book' => $book, 'author' => $author));
})->bind('book');