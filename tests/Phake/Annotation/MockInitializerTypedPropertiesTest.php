<?php

declare(strict_types=1);

if (PHP_VERSION_ID >= 70400) {
    $fp = fopen(__FILE__, 'r');
    fseek($fp, __COMPILER_HALT_OFFSET__);
    eval(stream_get_contents($fp));
}

__halt_compiler();

namespace Phake\Annotation;

/*
 * Phake - Mocking Framework
 *
 * Copyright (c) 2010-2022, Mike Lively <mike.lively@sellingsource.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *  *  Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *  *  Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *  *  Neither the name of Mike Lively nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Testing
 * @package    Phake
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.digitalsandwich.com/
 */

use Phake\Mock;
use PHPUnit\Framework\TestCase;
use PhakeTest\AnotherNamespacedClass;

/**
 * @ann1 Test Annotation
 * @ann2
 */
class MockInitializerTypesPropertiesTest extends TestCase
{
    /**
     * @Mock
     */
    private \stdClass $mock;

    private MockInitializer $initializer;

    #[Mock]
    private AnotherNamespacedClass $nativeMock;

    protected function setUp(): void
    {
        $this->initializer = new MockInitializer();
    }

    public function testInitialize()
    {
        $this->initializer->initialize($this);

        $this->assertInstanceOf(\stdClass::class, $this->mock);
    }

    public function testWithNativeReader()
    {
        if (PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Native attributes are not supported in PHP versions prior to 8.0');
        }

        $this->initializer = new MockInitializer(new NativeReader);
        $this->initializer->initialize($this);

        $this->assertInstanceOf(AnotherNamespacedClass::class, $this->nativeMock);
    }
}

