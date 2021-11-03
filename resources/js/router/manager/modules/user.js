import UserTable from '../../../pages/manager/user/UserTable';
import UserForm from '../../../pages/manager/user/UserForm';
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
