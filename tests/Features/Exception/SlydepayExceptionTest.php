<?php
/**
 * @package     Qodehub\Slydepay
 * @link        https://github.com/qodehub/slydepay-php
 *
 * @author      Ariama O. Victor (ovac4u) <victorariama@qodehub.com>
 * @link        http://www.ovac4u.com
 *
 * @license     https://github.com/qodehub/slydepay-php/blob/master/LICENSE
 * @copyright   (c) 2018, QodeHub, Ltd
 */

namespace Qodehub\Slydepay\Tests\Features\Exception;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\Exception\BadRequestException;
use Qodehub\Slydepay\Exception\Handler;
use Qodehub\Slydepay\Exception\InvalidRequestException;
use Qodehub\Slydepay\Exception\MissingParameterException;
use Qodehub\Slydepay\Exception\NotFoundException;
use Qodehub\Slydepay\Exception\SlydepayException;
use Qodehub\Slydepay\Exception\UnauthorizedException;
use Qodehub\Slydepay\Slydepay;
use Qodehub\Slydepay\Utility\SlydepayHandler;

class SlydepayExceptionTest extends TestCase
{
    /**
     * The configuration instance.
     * @var Config
     */
    protected $config;

    /**
     * This Package Version.
     *
     * @var string
     */
    protected $version = '1.0.0';
    /**
     * This will be the Authorization merchantKey
     *
     * @var string
     */
    protected $merchantKey = 'some-valid-merchantKey';
    /**
     * This is the emailOrPhoneNumber for the Slydepay Server
     *
     * @var string
     */
    protected $emailOrPhoneNumber = 1234567890;

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->emailOrPhoneNumber, $this->merchantKey);
    }

    public function useResponse($code = 200, $body = null)
    {
        $mock = new MockHandler([
            new Response($code, ['X-Foo' => 'Bar'], $body),
            new Response($code, ['Content-Length' => 0]),
            new RequestException("Error Communicating with Server", new Request('GET', 'test')),
        ]);

        $handler = (new SlydepayHandler($this->config, HandlerStack::create($mock)))->createHandler();

        $handler->remove('slydepay-retry-request');

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
        $this->expectException(SlydepayException::class);
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
