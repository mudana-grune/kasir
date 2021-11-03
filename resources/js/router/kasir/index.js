import transaksi from './modules/transaksi';
import dashboard from '../kasir/modules/dashboard';
import AppBase from '../../components/AppBase';
const KASIR = 1;
const kasirRoutes =
    {
        path: '/kasir',
        name: 'kasir.home',
        redirect: { name: 'kasir.dashboard'},
        meta: {
            main: true,
            auth: { roles: KASIR }
        },
        component: AppBase,
        children : [
            ...transaksi,
            ...dashboard
        ]
    };

export default kasirRoutes;
