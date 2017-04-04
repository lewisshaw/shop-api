<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

$app->get('/cart/{cartId:[a-zA-Z0-9]+}', Cart\Action\GetCart::class, 'get-cart');
$app->post('/cart', Cart\Action\CreateCart::class, 'create-cart');
$app->post('/cart/{cartId:[a-zA-Z0-9]+}/products', Cart\Action\UpsertCartProduct::class, 'upsert-cart-product');
$app->get('/products', Products\Action\GetProducts::class, 'get-products');
$app->get('/products/{productId:[0-9]+}', Products\Action\GetProduct::class, 'get-product');
