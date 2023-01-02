/**
 * Nextcloud - Tutorial3
 *
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Julien Veyssier <eneiluj@posteo.net>
 * @copyright Julien Veyssier 2023
 */

import {
	translate as t,
	// translatePlural as n,
} from '@nextcloud/l10n'
import { loadState } from '@nextcloud/initial-state'

function renderWidget(el) {
	const gifItems = loadState('tutorial_3', 'dashboard-widget-items')

	const paragraph = document.createElement('p')
	paragraph.textContent = t('tutorial_3', 'You can define the frontend part of a widget with plain Javascript.')
	el.append(paragraph)

	const paragraph2 = document.createElement('p')
	paragraph2.textContent = t('tutorial_3', 'Here is the list of files in your gif folder:')
	el.append(paragraph2)

	const list = document.createElement('ul')
	list.classList.add('widget-list')
	gifItems.forEach(item => {
		const li = document.createElement('li')
		li.textContent = item.title
		list.append(li)
	})
	el.append(list)
}

document.addEventListener('DOMContentLoaded', () => {
	OCA.Dashboard.register('tutorial3-simple-widget', (el, { widget }) => {
		renderWidget(el)
	})
})
