import UserTable from '../../../pages/admin/kasir/KasirTable';
import UserForm from '../../../pages/admin/kasir/KasirForm';
const user = [
    {
        path: '/manager/user',
        name: 'manager.user',
        component: UserTable
    },
    {
        path: '/manaager/user/add',
        name: 'manager.user.tambah',
        component: UserForm,
    },
    {
        path: '/manager/user/edit/:id',
        name: 'manager.user.edit',
        component: UserForm,
        meta: {
            editPage: true
        }
    }
];

export default user;
