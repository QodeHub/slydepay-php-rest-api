<?php
/**
 * @package     Qodehub\Bitgo
 * @link        https://github.com/qodehub/bitgo-php
 *
 * @author      Ariama O. Victor (ovac4u) <victorariama@qodehub.com>
 * @link        http://www.ovac4u.com
 *
 * @license     https://github.com/qodehub/bitgo-php/blob/master/LICENSE
 * @copyright   (c) 2018, QodeHub, Ltd
 */

namespace Qodehub\Bitgo\Tests\Features\Exception;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Exception\BadRequestException;
use Qodehub\Bitgo\Exception\BitgoException;
use Qodehub\Bitgo\Exception\Handler;
use Qodehub\Bitgo\Exception\InvalidRequestException;
use Qodehub\Bitgo\Exception\MissingParameterException;
use Qodehub\Bitgo\Exception\NotFoundException;
use Qodehub\Bitgo\Exception\UnauthorizedException;
use Qodehub\Bitgo\Utility\BitgoHandler;
use Qodehub\Bitgo\Wallet;

class BitgoExceptionTest extends TestCase
{

    /**
     * The bearer token that will be used by this API
     * @var string
     */
    protected $token = 'existing-token';

    /**
     * This will determine if HTTP(S) will be used
     * @var boolean
     */
    protected $secure = true;

    /**
     * This is the host on which the Bitgo API is running.
     * @var string
     */
    protected $host = 'some-host.com';

    /**
     * The configuration instance.
     * @var Config
     */
    protected $config;

    /**
     * This is the ID of the wallet used in this test
     * @var string
     */
    protected $walletId = 'existing-wallet-id';

    /**
     * This is the ID of the address used in this test
     * @var string
     */
    protected $addressId = 'existing-address';

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    public function useResponse($code = 200, $body = null)
    {
        $mock = new MockHandler([
            new Response($code, ['X-Foo' => 'Bar'], $body),
            new Response($code, ['Content-Length' => 0]),
            new RequestException("Error Communicating with Server", new Request('GET', 'test')),
        ]);

        $handler = (new BitgoHandler($this->config, HandlerStack::create($mock)))->createHandler();

        $handler->remove('bitgo-retry-request');

        $client = new Client(['handler' => $handler]);

        try {
            $client->get('http://localhost');
        } catch (ClientException $e) {
            throw new Handler($e);
        }
    }

    public function test_400_response()
    {
        $this->expectException(BadRequestException::class);
        $this->useResponse(400);
    }

    public function test_401_response()
    {
        $this->expectException(UnauthorizedException::class);
        $this->useResponse(401);
    }

    public function test_402_response()
    {
        $this->expectException(InvalidRequestException::class);
        $this->useResponse(402);
    }

    public function test_404_response()
    {
        $this->expectException(NotFoundException::class);
        $this->useResponse(404);
    }

    public function test_other_error_response()
    {
        $this->expectException(BitgoException::class);
        try {
            $this->useResponse(403);
        } catch (ClientException $e) {
            $this->assertContains('Some Field', $e->getMissingParameter());
            $this->assertContains('Other Field', $e->getMissingParameter());

            throw new Handler($e);
        }
    }

    public function test_500_response()
    {
        $this->expectException(\Exception::class);
        $this->useResponse(500);
    }

    public function test_501_response()
    {
        $this->expectException(\Exception::class);
        $this->useResponse(501);
    }

    public function test_502_response()
    {
        $this->expectException(\Exception::class);
        $this->useResponse(502);
    }

    public function test_504_response()
    {
        $this->expectException(\Exception::class);
        $this->useResponse(504);
    }

    public function test_4010_missingParameter_request_response()
    {
        $this->expectException(MissingParameterException::class);

        try {
            $this->useResponse(400, json_encode([
                'ResponseCode' => 4010,
                'Error' => [
                    array('Field' => 'Some Field'),
                    array('Field' => 'Other Field'),
                ],
            ]));
        } catch (MissingParameterException $e) {
            $this->assertSame(4010, $e->getErrorCode());
            $this->arrayHasKey('ResponseCode', $e->getRawOutput());
            $this->assertContains('MissingParameter', $e->getErrorType());
            $this->assertContains('Some Field', $e->getMissingParameter());
            $this->assertContains('Other Field', $e->getMissingParameter());

            throw $e;
        }
    }
}
