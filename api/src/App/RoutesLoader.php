<?php

namespace App;

use Silex\Application;

class RoutesLoader
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();

    }

    private function instantiateControllers()
    {
        $this->app['emojis.controller'] = $this->app->share(function () {
            return new Controllers\EmojisController($this->app['emojis.service']);
        });
        $this->app['advertisments.controller'] = $this->app->share(function () {
            return new Controllers\AdvertismentsController($this->app['advertisments.service']);
        });
         $this->app['logins.controller'] = $this->app->share(function () {
            return new Controllers\LoginsController($this->app['logins.service']);
        });

        $this->app['ppc.controller'] = $this->app->share(function () {
            return new Controllers\PPCController($this->app['ppc.service']);
        });

    }

    public function bindRoutesToControllers()
    {
        $api = $this->app["controllers_factory"];
        $api->get('/emojis', "emojis.controller:getAll");
        $api->post('/emojis', "emojis.controller:save");
        $api->post('/emoji-uploads/', "emojis.controller:uploadImage");
        $api->get('/emojiCategories', "emojis.controller:getAllCategories");
        $api->get('/emojis/{catId}', "emojis.controller:getAllEmojis");
        $api->get('/emojiCategories/{id}', "emojis.controller:getCategory");
        $api->delete('/emojiCategories/{id}', "emojis.controller:deleteCategory");
        $api->post('/emojiCategories', "emojis.controller:saveCategory");
        $api->put('/emojiCategories/{id}', "emojis.controller:updateCategory");
        $api->put('/emojis/{id}', "emojis.controller:update");
        $api->delete('/emojis/{id}', "emojis.controller:delete");
        $api->post('/advertisments', "advertisments.controller:save");
        $api->get('/advertisments', "advertisments.controller:getAll");
        $api->delete('/advertisments/{id}', "advertisments.controller:delete");
        $api->post('/registerClick',"ppc.controller:registerClick");
        $api->get('/getAllAdClickes',"ppc.controller:getAllAdClickes");
        $api->put('/advertisments/{id}', "advertisments.controller:update");
        $api->get('/freeCategories', "emojis.controller:getFreeCategories");
        $api->get('/paidCategories', "emojis.controller:getPaidCategories");
        $api->post('/admin_login_check', "logins.controller:login");
        $api->post('/admin_logout', "logins.controller:logout");
        $api->get('/getEmojiByCategory/{id}/{uuid}', "emojis.controller:getEmojiByCategory");
        $api->post('/recents/{emoji_id}/{uuid}', "emojis.controller:saveRecent");
        $api->post('/favorites/{emoji_id}/{uuid}', "emojis.controller:saveFavorite");
        $api->get('/getFavoriteEmojs/{uuid}', "emojis.controller:getFavoriteEmojs");
        $api->get('/getRecentEmojs/{uuid}', "emojis.controller:getRecentEmojs");
        $api->get('/themes/{uuid}', "emojis.controller:getTheme");
        $api->post('/themes/{color}/{uuid}', "emojis.controller:saveTheme");
        $api->get('/freeEmojis', "emojis.controller:getfreeEmojis");
        $api->get('/paidEmojis', "emojis.controller:getpaidEmojis");
        $api->post('/removeCategory/{uuid}/{id}', "emojis.controller:removeCategory");
        $api->post('/removeEmoji/{uuid}/{id}', "emojis.controller:removeEmoji");
        $api->post('/removeFavorite/{uuid}/{id}', "emojis.controller:removeFavorite");
        $api->post('/removeRecent/{uuid}/{id}', "emojis.controller:removeRecent");
        $api->post('/removeTheme/{uuid}/{id}', "emojis.controller:removeTheme");
        $api->get('/categoriesUUID', "emojis.controller:categoriesUUID");
        $api->get('/getCatName/{id}', "emojis.controller:getCatName");

        $this->app->mount($this->app["api.endpoint"].'/'.$this->app["api.version"], $api);
    }


   
}
 
