(function() {
	'use strict';

	angular.module('dashboard.users', [])
		.config(configure)

		.controller('DashboardUsersCtrl', DashboardUsersCtrl)
		.controller('DashboardUsersCtrl.edit', DashboardUsersCtrl_edit)
		.controller('DashboardUsersCtrl.changePassword', DashboardUsersCtrl_changePassword)
	;


	configure.$inject = ['$stateProvider'];
	function configure($stateProvider)
	{
		$stateProvider
			.state('users', {
				url: '/dashboard/users',
				abstract : true,
				views : {
					'' : {
						templateUrl: '/app/modules/dashboard/layout.html'
					}
				}
			})
			.state('users.list', {
				url: '',
				views : {
					content: {
						controller: 'DashboardUsersCtrl',
						templateUrl:  '/app/modules/dashboard/list.html'
					},
					'listItems@users.list': {
						templateUrl: '/app/modules/dashboard/users/list-item.html'
					}
				},
				resolve: {
					Items : function(HttpService) {
						return HttpService.get('/api/users');
					}
				},
				data: {
					urlAdd: 'users.create',
					title: 'List users'
				}
			})
			.state('users.create', {
				url: '/create',
				resolve: {
					Data : function(HttpService) {
						return HttpService.get('/api/users/create');
					}
				},
				views: {
					content: {
						controller: 'DashboardUsersCtrl.edit',
						templateUrl:  '/app/modules/dashboard/list.html'
					},
					'form_create@users.create': {
						templateUrl: '/app/modules/dashboard/users/create-form.html'
					}
				},
				data: {
					title: 'Create'
				}
			})
			.state('users.edit', {
				url: '/:id/edit',
				views: {
					content: {
						controller: 'DashboardUsersCtrl.edit',
						templateUrl:  '/app/modules/dashboard/list.html'
					},
					'form_create@users.edit': {
						templateUrl: '/app/modules/dashboard/users/edit-form.html'
					}
				},

				data: {
					title: 'Edit'
				},

				resolve: {
					Data : function(HttpService, $stateParams) {
						return HttpService.get('/api/users/' + $stateParams.id + '/edit');
					}
				}
			})
			.state('users.changePassword', {
				url: '/changePassword/:id',
				views: {
					content: {
						controller: 'DashboardUsersCtrl.changePassword',
						templateUrl:  '/app/modules/dashboard/list.html'
					},
					'form@users.changePassword': {
						templateUrl: '/app/modules/dashboard/users/change-password.html'
					}
				},
				data: {
					title: 'Change password'
				}
			});
	}

	DashboardUsersCtrl.$inject = ['$scope', '$state', 'Items', 'HttpService', 'BreadCrumbsService'];
	function DashboardUsersCtrl($scope, $state, Items, HttpService, BreadCrumbsService) {
		$scope.items = Items.data.users;
		BreadCrumbsService.addCrumb('List Users', 'users.list');

		$scope.changeItem = function(item) {
			HttpService.delete('/api/users' + item.id, $scope.item, function(resp) {
				$state.go($state.current, {}, {reload: true});
			});
		}
	}

	DashboardUsersCtrl_edit.$inject = ['$scope', '$state', 'HttpService', 'formErrors', 'Data', 'BreadCrumbsService'];
	function DashboardUsersCtrl_edit($scope, $state, HttpService, formErrors, Data, BreadCrumbsService) {
		BreadCrumbsService.addCrumb('Users', 'users.list');
		BreadCrumbsService.addCrumb('Edit');

		$scope.item = Data.data.user !== undefined ? Data.data.user : {};
		$scope.roles = Data.data.roles;

		$scope.changeItem = function() {
			if($scope.item.id === undefined) { //create
				console.log('a');
				HttpService.post('/api/users', $scope.item, function(resp) {
					$state.go('users.list');
				});
			} else {
				//update
				HttpService.put('/api/users' + $scope.item.id, $scope.item, function(resp) {
					$state.go('users.list');
				});
			}
		};
	}

	DashboardUsersCtrl_changePassword.$inject = ['$scope', '$state', 'HttpService', '$stateParams', 'formErrors', 'BreadCrumbsService'];
	function DashboardUsersCtrl_changePassword($scope, $state, HttpService, $stateParams, formErrors, BreadCrumbsService) {
		$scope.item = {};
		BreadCrumbsService.addCrumb('Users', 'users.list');
		BreadCrumbsService.addCrumb('Change Password');

		$scope.changeItem = function() {

			HttpService.post('/api/users/changePassword' + $stateParams.id, $scope.item, function(resp){
				$state.go('users.list');
			});
		}
	}

})();



