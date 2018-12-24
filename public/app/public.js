window.log = function(text) {
	if(typeof console == 'object' && BACKEND_CFG.ENV === 'local') {
		console.log(text);
	}
};

(function() {
	'use strict';

	// For templates
	angular
		.module('main.templates', [])
	;

	angular
		.module('main', [
			'ui.router',
			'ngDialog',
			'ngSanitize',
			'angularFileUpload',
			'angular-loading-bar',
			'main.templates',
			'notification',

			'directives.form',
			'directives.main',
			'shared.notify',


			'slick',

			'utils',
			'services',
			'common.filters',
			//'main.pages',
			'main.auth'
		])

		// SAMPLE CONTROLLERS. TO USE JUST UNCOMMENT

		//.controller('contactFormController', contactFormController)
		//.controller('subscribeFormController', subscribeFormController)
		//.controller('commentFormController', сommentFormController)

		.config(configure)
		.run(runBlock)
	;

	//BACKEND_CFG  : array of backend configuration - CSRF_TOKEN, files cfg etc.

	configure.$inject = ['$httpProvider', '$locationProvider', '$urlRouterProvider', 'cfpLoadingBarProvider', '$stateProvider'];
	function configure($httpProvider, $locationProvider, $urlRouterProvider, cfpLoadingBarProvider, $stateProvider)
	{
		$httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
		$httpProvider.defaults.useXDomain = true;

		$httpProvider.defaults.headers.common['X-Csrf-Token'] = BACKEND_CFG.CSRF_TOKEN;

		//$locationProvider.html5Mode({
		//	enabled: true,
		//	requireBase: false
		//});

		$stateProvider.state('lang', {
			//url: '/:language',
			url: '',
			template: '<ui-view></ui-view>',
			abstract: true
			//controller: function($state, $scope) {
			//	$scope.changeLanguage = function(language) {
			//		$state.go($state.current.name, {language: language});
			//	}
			//}
		});

		//$urlRouterProvider.otherwise("/en");

		//UNCOMMENT INTERCEPTORS IF NEEDED
		//$httpProvider.interceptors.push('postInterceptor');
		//$httpProvider.interceptors.push('authInterceptor');

		cfpLoadingBarProvider.includeSpinner = false;
	}

	runBlock.$inject = ['$rootScope', 'AuthService', 'SeoService', '$location', '$stateParams'];
	function runBlock($rootScope, AuthService, SeoService, $location, $stateParams) {
		$rootScope.BACKEND_CFG = BACKEND_CFG;

		//var lang = $location.path().split("/")[1] || 'en';
		//$stateParams.language = lang;


		// Init user session
		AuthService.create(function(res){
			$rootScope.AUTH = res;

			//get new messages count. Only for logged in
			if($rootScope.AUTH) {
				//do some stuff if is logged in
			}
		});

		//Loader
		$rootScope.$on('$stateChangeStart', function (event, next, current) {
			//Loader.start();
			//set SEO options from state
			SeoService.setTitleFromState(next);
			SeoService.setDescriptionFromState(next);
		});
		$rootScope.$on('$stateChangeSuccess', function (event, next, current) {
			//Loader.stop();
		});
		$rootScope.$on('$stateChangeError', function (event, next, current) {
			//Loader.stop();
		});

		$rootScope.$on('$viewContentLoaded', function(){

		});

		// For SEO
		$rootScope.getSeoTitle = SeoService.getTitle;
		$rootScope.getSeoDescription = SeoService.getDescription;
		//console.log($rootScope.getSeoDescription());

		//FAstclick
		//FastClick.attach(document.body);

		//Init Underscore in template
		$rootScope._ = _;

		// Check if not mobile client
		var isMobile = false;
		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Opera Mobile|Kindle|Windows Phone|PSP|AvantGo|Atomic Web Browser|Blazer|Chrome Mobile|Dolphin|Dolfin|Doris|GO Browser|Jasmine|MicroB|Mobile Firefox|Mobile Safari|Mobile Silk|Motorola Internet Browser|NetFront|NineSky|Nokia Web Browser|Obigo|Openwave Mobile Browser|Palm Pre web browser|Polaris|PS Vita browser|Puffin|QQbrowser|SEMC Browser|Skyfire|Tear|TeaShark|UC Browser|uZard Web|wOSBrowser|Yandex.Browser mobile/i.test(navigator.userAgent)) isMobile = true; //&& confirm('Are you on a mobile device?')
		$rootScope.isDesktop = !isMobile;

	}


	// SAMPLE FUNCTIONS FOR EXAMPLE. THEY ARE OFTEN USED


	//contactFormController.$inject = ['$scope','$http', 'Notify'];
	//function contactFormController($scope, $http, Notify) {
	//	$scope.contact = {};
	//
	//	$scope.contactFormPersist = function() {
	//		return $http.post('contact', $scope.contact)
	//				.success(function (resp) {
	//					$scope.contact = {};
	//					$scope.$emit('form:error', []);
	//					Notify.success(resp.message);
	//				})
	//				.error(function(resp) {
	//					//$scope.errors = resp;
	//
	//					$scope.$emit('form:error', resp);
	//				})
	//	}
	//}
	//
	//subscribeFormController.$inject = ['$scope','$http'];
	//function subscribeFormController($scope, $http) {
	//	$scope.subscribe = {};
	//	$scope.errors = {};
	//	$scope.subscriptionSuccess = false;
	//
	//	$scope.subscribeFormPersist = function() {
	//		return $http.post('/subscribe', $scope.subscribe)
	//				.success(function (resp) {
	//					$scope.subscribe = {};
	//					$scope.errors = {};
	//					$scope.subscriptionSuccess = true;
	//				})
	//				.error(function(resp) {
	//					$scope.errors = resp;
	//				})
	//	}
	//}
	//
	//сommentFormController.$inject = ['$scope','$http'];
	//function сommentFormController($scope, $http) {
	//	$scope.comment = {};
	//	$scope.errors = {};
	//	//$scope.inviteSuccess = false;
	//
	//	$scope.commentFormPersist = function() {
	//
	//		return $http.post('/comment', $scope.comment)
	//				.success(function (resp) {
	//					$scope.comment = {};
	//					$scope.errors = {};
	//					//$scope.inviteSuccess = true;
	//
	//					if(resp.html) {
	//						angular.element('#сomments').append(resp.html);
	//					}
	//				})
	//				.error(function(resp) {
	//					$scope.errors = resp;
	//				})
	//	}
	//}

})();

