<?php namespace Barryvdh\Elfinder\Session;

use elFinderSessionInterface;
use Illuminate\Contracts\Session\Session;

class LaravelSession implements elFinderSessionInterface
{
    public function __construct(protected Session $store)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        $this->store->start();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->store->save();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $empty = null)
    {
        return $this->store->get($key, $empty);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $data)
    {
        $this->store->put($key, $data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $this->store->remove($key);

        return $this;
    }
}
