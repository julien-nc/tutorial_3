const path = require('path')
// we extend the Nextcloud webpack config
const webpackConfig = require('@nextcloud/webpack-vue-config')
// this is to enable eslint and stylelint during compilation
const ESLintPlugin = require('eslint-webpack-plugin')
const StyleLintPlugin = require('stylelint-webpack-plugin')

const buildMode = process.env.NODE_ENV
const isDev = buildMode === 'development'
webpackConfig.devtool = isDev ? 'cheap-source-map' : 'source-map'

webpackConfig.stats = {
	colors: true,
	modules: false,
}

const appId = 'tutorial_3'
webpackConfig.entry = {
	dashboardSimple: { import: path.join(__dirname, 'src', 'dashboardSimple.js'), filename: appId + '-dashboardSimple.js' },
	dashboardVue: { import: path.join(__dirname, 'src', 'dashboardVue.js'), filename: appId + '-dashboardVue.js' },
}

// this enables eslint and stylelint during compilation
webpackConfig.plugins.push(
	new ESLintPlugin({
		extensions: ['js', 'vue'],
		files: 'src',
		failOnError: !isDev,
	})
)
webpackConfig.plugins.push(
	new StyleLintPlugin({
		files: 'src/**/*.{css,scss,vue}',
		failOnError: !isDev,
	}),
)

module.exports = webpackConfig
