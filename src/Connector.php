<?php namespace Barryvdh\Elfinder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Extended elFinder connector
 *
 * @author Dmitry (dio) Levashov
 **/
class Connector extends \elFinderConnector {

    /** @var Response */
    protected $response;

    /**
     * @return Response
     */
    public function getResponse(){
        return $this->response;
    }

    /**
     * Output json
     *
     * @param  array  data to output
     * @return void
     * @author Dmitry (dio) Levashov
     **/
    protected function output(array $data) {

        $headers = isset($data['header']) ? $data['header'] : $this->header;
        $headers = (array) $headers;

        unset($data['header']);

        if (isset($data['pointer'])) {
            $this->response = new StreamedResponse(function () use($data) {
                    rewind($data['pointer']);
                    fpassthru($data['pointer']);
                    if (!empty($data['volume'])) {
                        $data['volume']->close($data['pointer'], $data['info']['hash']);
                    }
                }, 200, $headers);
        } else {
            if (!empty($data['raw']) && !empty($data['error'])) {
                $this->response = new JsonResponse($data['error'], 500);
            } else {
                $this->response = new JsonResponse($data, 200, $headers);
            }
        }
    }
}
