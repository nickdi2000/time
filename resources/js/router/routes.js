export default [
  ...applyRules(['guest'], [
		//player portal
    { path: '/admin', name: 'admin', component: require('$comp/auth/AuthWrapper').default, redirect: { name: 'register' } ,children:
      [
        { path: '/login', name: 'login', component: require('$comp/auth/login/Login').default },
        { path: '/register', name: 'register', component: require('$comp/auth/register/Register').default },
        { path: '/password', component: require('$comp/auth/password/PasswordWrapper').default, children:
          [
            { path: '', name: 'forgot', component: require('$comp/auth/password/password-forgot/PasswordForgot').default },
            { path: 'reset/:token', name: 'reset', component: require('$comp/auth/password/password-reset/PasswordReset').default }
          ]
        }
      ]
    },
    { path: '', redirect: '/register'},
    { path: '/info', name: 'info', component: require('$comp/public/About').default },
    { path: '*', component: require('$comp/public/PlayerWrapper.vue').default,
      children: [
        { path: '', name: 'player', component: require('$comp/public/Player').default }
      ]
    },

  ]),
  ...applyRules(['auth'], [
    { path: '', component: require('$comp/admin/AdminWrapper').default, children:
      [
        { path: '', name: 'index', redirect: { name: 'map' } },
        { path: '/about', name: 'about', component: require('$comp/admin/about/About').default },
        { path: '/map', name: 'map', component: require('$comp/admin/map/MapWrapper').default },
        { path: '/super', name: 'super', component: require('$comp/admin/superadmin/SuperWrapper').default},
        { path: '/course-info', name: 'course-info', component: require('$comp/admin/superadmin/CourseInfo').default},
        { path: '/profile', component: require('$comp/admin/profile/ProfileWrapper').default, children:
          [
            { path: '', name: 'profile', component: require('$comp/admin/profile/Profile').default },
            { path: 'edit', name: 'profile-edit', component: require('$comp/admin/profile/edit/ProfileEdit').default }
          ]
        },
				  { path: '/course', component: require('$comp/admin/course/CourseWrapper').default, children:
	          [
	            { path: '', name: 'course', component: require('$comp/admin/course/Course').default },
	            { path: 'edit', name: 'course-edit', component: require('$comp/admin/course/CourseEdit').default }
	          ]
	        }
      ]
    },
  ]),

]

function applyRules(rules, routes) {
  for (let i in routes) {
    routes[i].meta = routes[i].meta || {}

    if (!routes[i].meta.rules) {
      routes[i].meta.rules = []
    }
    routes[i].meta.rules.unshift(...rules)

    if (routes[i].children) {
      routes[i].children = applyRules(rules, routes[i].children)
    }
  }

  return routes
}
