<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\DompdfBundle\Factory;

use Dompdf\Dompdf;
use Dompdf\Options;

final class DompdfFactory implements DompdfFactoryInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $options;

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function create(array $options = []): Dompdf
    {
        return new Dompdf($this->createOptions($options));
    }

    /**
     * @param array<string, mixed> $options
     */
    private function createOptions(array $options = []): Options
    {
        return new Options(array_merge($this->options, $options));
    }
}
