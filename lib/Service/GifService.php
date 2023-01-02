<?php

/**
 * Nextcloud - Tutorial3
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Julien Veyssier
 * @copyright Julien Veyssier 2023
 */

namespace OCA\Tutorial3\Service;

use OC\Files\Node\File;
use OC\Files\Node\Node;
use OC\User\NoUserException;
use OCA\Tutorial3\AppInfo\Application;
use OCP\Dashboard\Model\WidgetItem;
use OCP\Files\Folder;
use OCP\Files\InvalidPathException;
use OCP\Files\IRootFolder;
use OCP\Files\NotFoundException;
use OCP\Files\NotPermittedException;
use OCP\IURLGenerator;
use Psr\Log\LoggerInterface;


class GifService {

	public const GIF_DIR_NAME = 'gifs';

	/**
	 * @var IRootFolder
	 */
	private $root;
	/**
	 * @var LoggerInterface
	 */
	private $logger;
	/**
	 * @var IURLGenerator
	 */
	private $urlGenerator;

	public function __construct (IRootFolder $root,
								LoggerInterface $logger,
								IURLGenerator $urlGenerator) {
		$this->root = $root;
		$this->logger = $logger;
		$this->urlGenerator = $urlGenerator;
	}

	/**
	 * @param string $userId
	 * @return array|string[]
	 * @throws NotFoundException
	 * @throws NotPermittedException
	 * @throws NoUserException
	 */
	public function getGifFiles(string $userId): array {
		$userFolder = $this->root->getUserFolder($userId);
		if ($userFolder->nodeExists(self::GIF_DIR_NAME)) {
			$gifDir = $userFolder->get(self::GIF_DIR_NAME);
			if ($gifDir instanceof Folder) {
				$nodeList = $gifDir->getDirectoryListing();
				return array_filter($nodeList, static function (Node $node) {
					return $node instanceof File;
				});
			} else {
				return [
					'error' => '/' . self::GIF_DIR_NAME . ' is a file',
				];
			}
		}
		return [];
	}

	/**
	 * @param string $userId
	 * @param int $fileId
	 * @return File|null
	 * @throws NoUserException
	 * @throws NotFoundException
	 * @throws NotPermittedException
	 * @throws InvalidPathException
	 */
	public function getGifFile(string $userId, int $fileId): ?File {
		$userFolder = $this->root->getUserFolder($userId);
		if ($userFolder->nodeExists(self::GIF_DIR_NAME)) {
			$gifDir = $userFolder->get(self::GIF_DIR_NAME);
			if ($gifDir instanceof Folder) {
				$gifDirId = $gifDir->getId();
				// Folder::getById() returns a list because one file ID can be found multiple times
				// if it was shared multiple times for example
				$files = $gifDir->getById($fileId);
				foreach ($files as $file) {
					if ($file instanceof File && $file->getParent()->getId() === $gifDirId) {
						return $file;
					}
				}
			}
		}
		$this->logger->debug('File ' . $fileId . ' was not found in the gif folder', ['app' => Application::APP_ID]);
		return null;
	}

	public function getWidgetItems(string $userId): array {
		$files = $this->getGifFiles($userId);
		if (isset($files['error'])) {
			return [];
		}
		return array_map(function (File $file) {
			return new WidgetItem(
				$file->getName(),
				'',
				$this->urlGenerator->linkToRouteAbsolute('files.View.showFile', ['fileid' => $file->getId()]),
				// if we want to get a preview instead of the full file (gif previews are static)
				// $this->urlGenerator->linkToRouteAbsolute('core.Preview.getPreviewByFileId', ['x' => 32, 'y' => 32, 'fileId' => $file->getId()]),
				$this->urlGenerator->linkToRouteAbsolute('tutorial_3.tutorial.getGifFile', ['fileId' => $file->getId()]),
				(string) $file->getMTime()
			);
		}, $files);
	}
}
