<?php declare(strict_types = 1);

namespace App;

use Nette\Bootstrap\Configurator;
use Nette\InvalidStateException;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;

class Bootstrap
{

	private const ASSETS_MANIFEST_PATH = __DIR__ . '/../config/manifest.json';

	public static function boot(): Configurator
	{
		$configurator = new Configurator();
		$appDir = dirname(__DIR__);

		$debugMode = getenv('NETTE_DEBUG');
		$configurator->setDebugMode((bool) $debugMode);
		$configurator->enableTracy($appDir . '/log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory($appDir . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig($appDir . '/config/common.neon');
		if (file_exists($appDir . '/config/local.neon')) {
			$configurator->addConfig($appDir . '/config/local.neon');
		}

		return $configurator;
	}

	public static function loadAsset(string $asset): ?string
	{
		$manifestExists = file_exists(self::ASSETS_MANIFEST_PATH);
		if ($manifestExists === false) {
			return null;
		}
		$manifestContent = file_get_contents(self::ASSETS_MANIFEST_PATH);
		if ($manifestContent === false) {
			return null;
		}
		$manifest = json_decode($manifestContent, true);
		if ($manifest === false) {
			return null;
		}
		if (Strings::endsWith($asset, '.webp')) {
			$pngAsset = $manifest[self::changeExtension($asset, 'png')] ?? null;
			if ($pngAsset !== null) {
				return self::changeExtension($pngAsset, 'webp');
			}
			$jpgAsset = $manifest[self::changeExtension($asset, 'jpg')] ?? null;
			if ($jpgAsset !== null) {
				return self::changeExtension($jpgAsset, 'webp');
			}
			return null;
		}
		return $manifest[$asset] ?? null;
	}

	private static function changeExtension(string $name, string $extension): string
	{
		$parts = explode('.', $name);
		array_pop($parts);
		$parts[] = $extension;
		return implode('.', $parts);
	}

	public static function getAsset(string $asset): ?string
	{
		$assetPath = self::loadAsset($asset);
		if ($assetPath !== null) {
			return $assetPath;
		}
		throw new InvalidStateException(sprintf(
			'Missing asset "%s" in "%s". Please compile assets using Webpack.',
			$asset,
			FileSystem::normalizePath(self::ASSETS_MANIFEST_PATH),
		));
	}

}
