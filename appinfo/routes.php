<?php
/**
 * Nextcloud - Tutorial3
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Julien Veyssier <eneiluj@posteo.net>
 * @copyright Julien Veyssier 2022
 */

return [
	'routes' => [
		['name' => 'tutorial#getGifFile', 'url' => '/gif/{fileId}', 'verb' => 'GET'],
	],
];
