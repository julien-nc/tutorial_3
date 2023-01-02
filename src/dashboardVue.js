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

import Vue from 'vue'
import './vueBootstrap.js'
import GifWidget from './views/GifWidget.vue'

document.addEventListener('DOMContentLoaded', () => {
	OCA.Dashboard.register('tutorial3-vue-widget', (el, { widget }) => {
		const View = Vue.extend(GifWidget)
		new View({
			propsData: { title: widget.title },
		}).$mount(el)
	})
})
