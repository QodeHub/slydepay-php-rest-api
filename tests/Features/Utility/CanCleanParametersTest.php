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

namespace Qodehub\Slydepay\Tests\Features\Wallet;

use PHPUnit\Framework\TestCase;
use Qodehub\Slydepay\Utility\CanCleanParameters;

class CanCleanParametersTest extends TestCase
{
    /** @test */
    public function a_required_parameter_should_throw_an_error_if_it_has_no_related_get_method()
    {
        $instance = new ClassSample;

        $this->expectException(\RuntimeException::class);

        $instance->run();
    }
}

/**
 * Class ClassSample
 */
class ClassSample
{
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'requiredField',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'optionalField',
    ];

    public function run()
    {
        $this->propertiesPassRequired();

        return true;
    }
}
