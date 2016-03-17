<?php namespace Barryvdh\Elfinder\Session;

use elFinderSessionInterface;
use Illuminate\Session\Store;

class LaravelSession implements elFinderSessionInterface
{
    /** @var Store  */
    protected $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
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
        $this->store->set($key, $data);

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