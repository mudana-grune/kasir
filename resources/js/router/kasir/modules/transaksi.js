import TransaksiTable from '../../../pages/user/transaksi/TransaksiTable';
import TransaksiForm from '../../../pages/user/transaksi/TransaksiForm';

const transaksi = [
    {
        path: '/kasir/transaksi',
        name: 'kasir.transaksi',
        compoonent: TransaksiTable,
    },
    {
        path: '/kasir/transaksi/add',
        name: 'kasir.transaksi.tambah',
        compoonent: TransaksiForm
    }
];

export default transaksi;
