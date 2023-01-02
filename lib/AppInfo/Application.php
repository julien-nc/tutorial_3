<?php
/**
 * Nextcloud - Tutorial3
 *
 *
 * @author Julien Veyssier <eneiluj@posteo.net>
 * @copyright Julien Veyssier 2023
 */

namespace OCA\Tutorial3\AppInfo;

use OCA\Tutorial3\Dashboard\SimpleWidget;
use OCA\Tutorial3\Dashboard\VueWidget;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;

class Application extends App implements IBootstrap {
	public const APP_ID = 'tutorial_3';

	public function __construct(array $urlParams = []) {
		parent::__construct(self::APP_ID, $urlParams);
	}

	public function register(IRegistrationContext $context): void {
		$context->registerDashboardWidget(VueWidget::class);
		$context->registerDashboardWidget(SimpleWidget::class);
	}

	public function boot(IBootContext $context): void {
	}
}

