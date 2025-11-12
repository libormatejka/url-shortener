const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const WebpackAssetsManifest = require('webpack-assets-manifest');
const ImageminWebpWebpackPlugin = require("imagemin-webp-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const { VueLoaderPlugin } = require('vue-loader')

module.exports = (env, args) => {
	const production = args.mode === 'production';
	return {
		entry: {
			admin: path.resolve(__dirname, 'assets/admin.js'),
			front: path.resolve(__dirname, 'assets/front.js'),
		},
		output: {
			filename: "js/[name].js",
			path: path.resolve(__dirname, 'www/assets'),
			publicPath: "/assets/",
		},
		module: {
			rules: [
				{
					test: /\.m?js$/,
					exclude: /node_modules/,
					use: {
						loader: 'babel-loader',
						options: {
							presets: [
								[
									'@babel/preset-env',
									{
										targets: "defaults",
									},
								],
							],
							plugins: [
								"@babel/plugin-transform-runtime",
							],
						},
					},
				},
				{
					test: /\.vue$/,
					use: 'vue-loader'
				},
				{
					test: /\.(woff2|woff|eot|otf|ttf)$/,
					loader: 'file-loader',
					options: {
						name: 'fonts/[name].[ext]',
					},
					type: 'javascript/auto',
				},
				{
					test: /\.(png|jpg|gif|svg|ico|webp)$/,
					loader: 'file-loader',
					options: {
						name: 'img/[name].[ext]',
					},
					type: 'javascript/auto',
				},
				{
					test: /\.(css|scss|sass)$/,
					use: [
						production ? MiniCssExtractPlugin.loader : 'style-loader',
						{
							loader: 'css-loader',
							options: {
								sourceMap: false,
							},
						},
						'postcss-loader',
						'sass-loader',
					],
				},
			],
		},
		plugins: [
			new VueLoaderPlugin(),
			new MiniCssExtractPlugin({
				filename: 'css/[name].css',
			}),
			new WebpackAssetsManifest({
				output: path.resolve(__dirname, 'config/manifest.json'),
				publicPath: true,
			}),
			new ImageminWebpWebpackPlugin({
				config: [{
					test: /\.(jpe?g|png)/,
					options: {
						quality: 100,
					},
				}],
				overrideExtension: true,
				strict: true,
			}),
		],
		optimization: {
			minimizer: [
				new CssMinimizerPlugin(),
				new TerserPlugin(),
			],
		},
		devServer: {
			port: 8080,
			proxy: {
				'/': {
					target: 'http://nginx:80',
					secure: false,
				},
			},
		},
		resolve: {
			extensions: [".js", ".vue"],
			alias: {
				vue: "@vue/runtime-dom"
			}
		},
		performance: {
			hints: false,
		},
	};
};
