<?php

namespace App;

use Silex\Application;
use App\Services\EmojisService;
use App\Services\AdvertismentsService;
use App\Services\LoginsService;

class ServicesLoader
{
    protected $app;

    public function __construct(Application $app)
    {

        $this->app = $app;
    }

    public function bindServicesIntoContainer()
    {

        $this->app['emojis.service'] = $this->app->share(function () {
            return new EmojisService($this->app["db"]);
        });

        $this->app['advertisments.service'] = $this->app->share(function () {
            return new Services\AdvertismentsService($this->app["db"]);
        });
         $this->app['logins.service'] = $this->app->share(function () {
            return new Services\LoginsService($this->app["db"]);
        });
        $this->app['ppc.service'] = $this->app->share(function () {
            return new Services\PPCService($this->app["db"]);
        });
    }
   
}
