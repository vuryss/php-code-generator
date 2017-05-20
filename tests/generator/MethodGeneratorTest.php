<?php
namespace gossi\codegen\tests\generator;

use gossi\codegen\generator\ModelGenerator;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;

/**
 * @group generator
 */
class MethodGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function testPublic() {
		$expected = "public function foo()\n{\n}\n";
	
		$method = PhpMethod::create('foo');
		$generator = new ModelGenerator();
		$code = $generator->generate($method);
	
		$this->assertEquals($expected, $code);
	}
	
	public function testProtected() {
		$expected = "protected function foo()\n{\n}\n";

		$method = PhpMethod::create('foo')->setVisibility(PhpMethod::VISIBILITY_PROTECTED);
		$generator = new ModelGenerator();
		$code = $generator->generate($method);

		$this->assertEquals($expected, $code);
	}
	
	public function testPrivate() {
		$expected = "private function foo()\n{\n}\n";
	
		$method = PhpMethod::create('foo')->setVisibility(PhpMethod::VISIBILITY_PRIVATE);
		$generator = new ModelGenerator();
		$code = $generator->generate($method);
	
		$this->assertEquals($expected, $code);
	}
	
	public function testStatic() {
		$expected = "public static function foo()\n{\n}\n";
	
		$method = PhpMethod::create('foo')->setStatic(true);
		$generator = new ModelGenerator();
		$code = $generator->generate($method);
	
		$this->assertEquals($expected, $code);
	}
	
	public function testAbstract() {
		$expected = "abstract public function foo();\n";
	
		$method = PhpMethod::create('foo')->setAbstract(true);
		$generator = new ModelGenerator();
		$code = $generator->generate($method);
	
		$this->assertEquals($expected, $code);
	}
	
	public function testReferenceReturned() {
		$expected = "public function & foo()\n{\n}\n";
	
		$method = PhpMethod::create('foo')->setReferenceReturned(true);
		$generator = new ModelGenerator();
		$code = $generator->generate($method);
	
		$this->assertEquals($expected, $code);
	}
	
	public function testParameters() {
		$generator = new ModelGenerator();
		
		$method = PhpMethod::create('foo')->addParameter(PhpParameter::create('bar'));
		$this->assertEquals("public function foo(\$bar)\n{\n}\n", $generator->generate($method));
		
		$method = PhpMethod::create('foo')
			->addParameter(PhpParameter::create('bar'))
			->addParameter(PhpParameter::create('baz'));
		$this->assertEquals("public function foo(\$bar, \$baz)\n{\n}\n", $generator->generate($method));
	}
	
	public function testReturnType() {
		$expected = "public function foo(): int\n{\n}\n";
		$generator = new ModelGenerator(['generateReturnTypeHints' => true, 'generateDocblock' => false]);

		$method = PhpMethod::create('foo')->setType('int');
		$this->assertEquals($expected, $generator->generate($method));
	}

}
