<?php namespace Barryvdh\Elfinder\Support;

use Illuminate\Foundation\Application;

if (class_exists('Illuminate\Routing\Controller')) {
    // Laravel 4.1+ Controller
    class BaseController extends \Illuminate\Routing\Controller
    {
        /**
         * The application instance.
         *
         * @var \Illuminate\Foundation\Application
         */
        protected $app;

        public function __construct(Application $app)
        {
            $this->app = $app;
        }
    }
} else if (class_exists('Illuminate\Routing\Controllers\Controller')) {
    // Laravel 4.0 Controller
    class BaseController extends \Illuminate\Routing\Controllers\Controller
    {
        /**
         * The application instance.
         *
         * @var \Illuminate\Foundation\Application
         */
        protected $app;

        public function __construct()
        {
            $this->app = app();
        }
    }
} else {
    // Plain Old PHP Object
    class BaseController
    {
        /**
         * The application instance.
         *
         * @var \Illuminate\Foundation\Application
         */
        protected $app;

        public function __construct(Application $app)
        {
            $this->app = $app;
        }
    }
}
