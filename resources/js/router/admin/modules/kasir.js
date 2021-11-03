import KasirTable from '../../../pages/admin/kasir/KasirTable';
import KasirForm from '../../../pages/admin/kasir/KasirForm';

const kasir = [
    {
        path: '/admin/kasir',
        name: 'admin.kasir',
        component: KasirTable,
    },
    {
        path: '/admin/kasir/add',
        name: 'admin.kasir.tambah',
        component: KasirForm
    },
    {
        path: '/admin/kasir/edit/:id',
        name: 'admin.kasir.edit',
        component: KasirForm,
        meta: {
            editPage: true,
        }
    }
];

export default kasir;
