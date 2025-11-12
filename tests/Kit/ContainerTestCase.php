<?php declare(strict_types = 1);

namespace Tests\Kit;

use App\Bootstrap;
use Nette\DI\Container;
use PHPUnit\Framework\TestCase;

abstract class ContainerTestCase extends TestCase
{

	private ?Container $container = null;

	private function createContainer(): Container
	{
		return Bootstrap::boot()->createContainer();
	}

	protected function getContainer(): Container
	{
		if($this->container === null)
		{

			$this->container = $this->createContainer();

		}

		return $this->container;
	}

}
