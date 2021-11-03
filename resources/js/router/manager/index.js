import user from './modules/user';
import AppBase from '../../components/AppBase';
import dashboard from './modules/dashboard';

const MANAGER = 3;
const managerRoutes = {
    path: '/manager',
    name: 'manager.home',
    redirect: { name: 'manager.dashboard'},
    component: AppBase,
    meta: {
        auth: {roles: MANAGER, redirect: {name: 'login'}, forbiddenRedirect: '/403'},
        main: true
    },
    children : [
        ...user,
        ...dashboard
    ]
}

export default managerRoutes;
