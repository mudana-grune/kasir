import CabangTable from '../../../pages/manager/cabang/CabangTable';
import CabangForm from '../../../pages/manager/cabang/CabangForm';

const cabang = [
    {
        path: '/manager/cabang',
        name: 'manager.cabang.list',
        component: CabangTable
    },
    {
        path: '/manager/cabang/add',
        name: 'manager.cabang.tambah',
        component: CabangForm,
    },
    {
        path: '/manager/cabang/edit/:id',
        name: 'manager.cabang.edit',
        component: CabangForm,
        meta: {
            editPage: true,
        }
    }
];

export default cabang;
