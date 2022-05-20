export default [
  ...applyRules(['guest'], [
		//player portal
    { path: '', component: require('$comp/auth/AuthWrapper').default, redirect: { name: 'login' }, children:
      [

        { path: '/login', name: 'login', component: require('$comp/auth/login/Login').default },
        { path: '/registerr', name: 'register', component: require('$comp/auth/register/Register').default },
        { path: '/register', name: 'register-contact', component: require('$comp/auth/register/RegisterClosed').default },
        { path: '/password', component: require('$comp/auth/password/PasswordWrapper').default, children:
          [
            { path: '', name: 'forgot', component: require('$comp/auth/password/password-forgot/PasswordForgot').default },
            { path: 'reset/:token', name: 'reset', component: require('$comp/auth/password/password-reset/PasswordReset').default }
          ]
        }
      ]
    },
    { path: '', redirect: '/find'},
    { path: '/map', name: 'login', component: require('$comp/public/map/MapWrapper').default },
    { path: '/info', name: 'info', component: require('$comp/public/About').default },
    { path: '/find', name: 'find-course', component: require('$comp/public/Find').default },
    { path: '/app/sampler', name: 'sampler', component: require('$comp/etc/Sampler').default },
    { path: '/*', component: require('$comp/public/PlayerWrapper.vue').default,
      children: [
        { path: '', name: 'player', component: require('$comp/public/Player').default }
      ]
    },
  ]),
  ...applyRules(['auth'], [
    { path: '', component: require('$comp/admin/AdminWrapper').default, children:
      [
        { path: '', name: 'index', redirect: { name: 'map' } },
        { path: '/about', name: 'about', component: require('$comp/admin/about/AboutWrapper').default },
        { path: '/map', name: 'map', component: require('$comp/admin/map/MapWrapper').default },
        { path: '/menu', name: 'menu', component: require('$comp/admin/menu/MenuWrapper').default },
        { path: '/test', name: 'map', component: require('$comp/admin/map/Test').default },
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
  { path: '*', redirect: { name: 'index' } }

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
