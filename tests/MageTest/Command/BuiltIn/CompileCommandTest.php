<?php

namespace MageTest\Command\BuiltIn;

use MageTest\TestHelper\BaseTest;
use Mage\Command\BuiltIn\CompileCommand;
use phpmock\phpmock\FixedValueFunction;
use phpmock\phpmock\MockBuilder;

/**
 * Class CompileCommandTest
 * @package MageTest\Command\BuiltIn
 * @coversDefaultClass Mage\Command\BuiltIn\CompileCommand
 * @uses phpmock\phpmock\FixedValueFunction
 * @uses phpmock\phpmock\Mock
 * @uses phpmock\phpmock\MockBuilder
 * @uses Mage\Console
 * @uses Mage\Console\Colors
 */
class CompileCommandTest extends BaseTest
{
    /**
     * @var FixedValueFunction
     */
    private $iniGetValue;

    /**
     * @before
     */
    public function before()
    {
        $this->iniGetValue = new FixedValueFunction();
        $mockBuilder       = new MockBuilder();
        $iniGetMock        = $mockBuilder->setNamespace('Mage\Command\BuiltIn')
            ->setName("ini_get")
            ->setCallableProvider($this->iniGetValue)
            ->build();
        $iniGetMock->disable();
        $iniGetMock->enable();

        $this->setUpConsoleStatics();
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $compilerMock   = $this->getMock('Mage\Compiler');
        $compileCommand = new CompileCommand($compilerMock);

        $compilerProperty = $this->getPropertyValue($compileCommand, 'compiler');

        $this->assertInstanceOf('Mage\Compiler', $compilerProperty);
        $this->assertSame($compilerMock, $compilerProperty);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructWithNoParams()
    {
        $compileCommand   = new CompileCommand();
        $compilerProperty = $this->getPropertyValue($compileCommand, 'compiler');

        $this->assertInstanceOf('Mage\Compiler', $compilerProperty);
    }

    /**
     * @covers ::__construct
     * @covers ::run
     */
    public function testRun()
    {
        $expectedOutput   = "mage.phar compiled successfully\n\n";
        $expectedExitCode = 0;
        $this->expectOutputString($expectedOutput);

        $this->iniGetValue->setValue(false);

        $compilerMock = $this->getMock('Mage\Compiler');
        $compilerMock->expects($this->once())
            ->method('compile');
        $compileCommand = new CompileCommand($compilerMock);

        $actualExitCode = $compileCommand->run();

        $this->assertEquals($expectedExitCode, $actualExitCode);
    }

    /**
     * @covers ::__construct
     * @covers ::run
     */
    public function testRunWhenPharReadonlyEnabled()
    {
        $expectedOutput   = "\tThe php.ini variable phar.readonly must be Off.\n\n";
        $expectedExitCode = 200;
        $this->expectOutputString($expectedOutput);
        $this->iniGetValue->setValue(true);

        $compilerMock   = $this->getMock('Mage\Compiler');
        $compileCommand = new CompileCommand($compilerMock);
        $actualExitCode = $compileCommand->run();

        $this->assertEquals($expectedExitCode, $actualExitCode);
    }
}
