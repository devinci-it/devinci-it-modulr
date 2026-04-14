<?php
/**
 * Class Response
 *
 * Represents an HTTP response.
 */

namespace DevinciIT\Modulr\Http;

class Response
{
    /**
     * Send a response to the client.
     *
     * @param string $content
     * @param int $status
     * @return void
     */
    public function send(string $content, int $status = 200): void
    {
        http_response_code($status);
        echo $content;
    }
}
