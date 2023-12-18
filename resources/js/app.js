/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


//const { default: Axios } = require('axios');

/////require('./jquery'); 
//require('./bootstrap.js');


//window.Vue = require('vue');
//require('toastr');
//require('axios');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('loadingplane', require('../components/Loadingplane.vue'));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*const app = new Vue({
    el: '#coordination',
    created: function(){
               
        this.getCoordination();
    }
});*/

const app = new Vue({
    el: '#invoiceitem',
    created: function(){
               
        this.getInvoiceItems();
        this.getMasterInvoices();
    },
    data: {
        // invoice Items
        invoiceitems: [],
        invoiceheader: [],
        total_fulls: '',
        id_invoiceh: '', 
        id_client: '', 
        id_farm: '', 
        id_load: '', 
        variety_id: '', 
        hawb: '', 
        pieces: '',
        hb: '',
        qb: '',
        eb: '', 
        stems: '', 
        price: '',
        bunches: '', 
        fulls: '',    
        total: '',
        id_user: '',
        update_user: '',
        stems_p_bunches: '',
        fa_cl_de: '',
        client_confim_id: '',
        errors: [],
        fillInvoiceItem: {
            'total_fulls': '',
            'id_invoiceh': '', 
            'id_client': '', 
            'id_farm': '', 
            'id_load': '', 
            'variety_id': '', 
            'hawb': '', 
            'pieces': '',
            'hb': '',
            'qb': '',
            'eb': '', 
            'stems': '', 
            'price': '',
            'bunches': '', 
            'fulls': '',    
            'total': '',
            'id_user': '',
            'update_user': '',
            'stems_p_bunches': '',
            'fa_cl_de': '',
            'client_confim_id': ''
        },
        fillHeader: {
            'coordination': ''
        },
        masterInvoices: [],

    },
    methods: {

        // Usar las fincas y clientes de la coordinacion en la Master Invoice
        updateInfoCoordination: function(id){
            
            var id_load = $('#id_load').val();
            var urlInvoiceItems = 'masterinvoices/' + id;
            var status = '';
            //var messageCoord = '';
            if ($('#infoCoordination').is(':checked') ) {
                status = 'yes';
                messageCoord = 'Se usarán las fincas de la coordinación';
            }else{
                status = 'no';
                messageCoord = 'Se usarán todas las fincas';
            }
            this.fillHeader.coordination = status;

            axios.put(urlInvoiceItems, this.fillHeader).then(response => {
                //this.getMasterInvoices();
                location.reload();
                this.errors = [];
                toastr.success(messageCoord);
            });

            //var infoCoord = $('#infoCoordination').val();
        },

        // Usar las fincas y clientes de la coordinacion en las Pallets
        updateInfoCoordinationInPallets: function(id){
            
            var urlInvoiceItems = 'masterinvoices/' + id;
            var status = '';
            //var messageCoord = '';
            if ($('#infoCoordinationPallets').is(':checked') ) {
                status = 'yes';
                messageCoord = 'Se usarán las fincas de la coordinación';
            }else{
                status = 'no';
                messageCoord = 'Se usarán todas las fincas';
            }
            this.fillHeader.coordination = status;

            axios.put(urlInvoiceItems, this.fillHeader).then(response => {
                //this.getMasterInvoices();
                location.reload();
                this.errors = [];
                toastr.success(messageCoord);
            });

            //var infoCoord = $('#infoCoordination').val();
        },

        getMasterInvoices: function()
        {
            var id_load = $('#id_load').val();
            var urlMasterInvoice = 'masterinvoices?' + id_load;
            axios.get(urlMasterInvoice).then(response => {
                this.masterInvoices = response.data
            });
        },

        // Invoice Items
        getInvoiceItems: function(){
            var id_load = $('#id_load').val();
            //alert(id_load);
            var urlInvoiceItems = 'invoicesitems/' + id_load;
            axios.get(urlInvoiceItems).then(response => {
                this.invoiceitems = response.data
            });
        },
        editInvoiceItem: function(item){
            this.fillInvoiceItem.id = item.id;
            this.fillInvoiceItem.id_invoiceh = item.id_invoiceh;
            this.fillInvoiceItem.id_client = item.id_client;
            this.fillInvoiceItem.id_farm = item.id_farm;
            this.fillInvoiceItem.id_load = item.id_load;
            this.fillInvoiceItem.variety_id = item.variety_id;
            this.fillInvoiceItem.hawb = item.hawb;
            this.fillInvoiceItem.pieces = item.pieces;
            this.fillInvoiceItem.hb = item.hb;
            this.fillInvoiceItem.qb = item.qb;
            this.fillInvoiceItem.eb = item.eb;
            this.fillInvoiceItem.stems = item.stems;
            this.fillInvoiceItem.price = item.price;
            this.fillInvoiceItem.bunches = item.bunches;
            this.fillInvoiceItem.fulls = item.fulls;
            this.fillInvoiceItem.total = item.total;
            this.fillInvoiceItem.id_user = item.id_user;
            this.fillInvoiceItem.update_user = item.update_user;
            this.fillInvoiceItem.stems_p_bunches = item.stems_p_bunches;
            this.fillInvoiceItem.fa_cl_de = item.fa_cl_de;
            this.fillInvoiceItem.client_confim_id = item.client_confim_id;
            $('#editarItem').modal('show');
        },
        updateInvoiceItem: function(id){
            var urlUpdateInvoiceItems = 'masterinvoicesitems/' + id;

            // Calculo de los total de piezas.
            this.fillInvoiceItem.pieces = parseInt(this.fillInvoiceItem.hb) + parseInt(this.fillInvoiceItem.qb) + parseInt(this.fillInvoiceItem.eb);
            // Calculo de los fulls.
            this.fillInvoiceItem.fulls = parseFloat(this.fillInvoiceItem.hb * 0.50) + parseFloat(this.fillInvoiceItem.qb * 0.25) + parseFloat(this.fillInvoiceItem.eb * 0.125);
            this.fillInvoiceItem.fa_cl_de = this.fillInvoiceItem.id_farm + '-' + this.fillInvoiceItem.id_client + '-' + this.fillInvoiceItem.variety_id + '-' + $('#Editid_invoiceh').val();
            this.fillInvoiceItem.id_invoiceh = $('#Editid_invoiceh').val();
            this.fillInvoiceItem.id_load = $('#Editid_load').val();
            this.fillInvoiceItem.price = parseFloat(this.fillInvoiceItem.price);
            this.fillInvoiceItem.bunches = $('#Editbunches').val();
            this.fillInvoiceItem.total = parseFloat($('#Edittotal').val());
            this.fillInvoiceItem.update_user = $('#Editupdate_user').val();

            axios.put(urlUpdateInvoiceItems, this.fillInvoiceItem).then(response => {
                this.getInvoiceItems();
                this.fillInvoiceItem = {
                    'total_fulls': '',
                    'id_invoiceh': '', 
                    'id_client': '', 
                    'id_farm': '', 
                    'id_load': '', 
                    'variety_id': '', 
                    'hawb': '', 
                    'pieces': '',
                    'hb': '',
                    'qb': '',
                    'eb': '', 
                    'stems': '', 
                    'price': '',
                    'bunches': '', 
                    'fulls': '',    
                    'total': '',
                    'id_user': '',
                    'update_user': '',
                    'stems_p_bunches': '',
                    'fa_cl_de': '',
                    'client_confim_id': ''
                };
                this.errors = [];
                $('#editarItem').modal('hide');
                toastr.success('Item actualizado correctamente');
            }).catch(error => {
                this.errors = error.response.data
            });
        },
        deleteInvoiveItem: function(item){
            var urlDelete = 'masterinvoicesitems/' + item.id;
            axios.delete(urlDelete).then(response => { // Eliminamos
                this.getInvoiceItems(); // Listamos
                toastr.success('Eliminado correctamente'); // Mensaje
            });
            
        },
        createInvoiceItem: function(){
            var url = 'masterinvoicesitems';
            
            // Calculo de los total de piezas.
            this.pieces = parseInt(this.hb) + parseInt(this.qb) + parseInt(this.eb);
            // Calculo de los fulls.
            this.fulls = parseFloat(this.hb * 0.50) + parseFloat(this.qb * 0.25) + parseFloat(this.eb * 0.125);
            var fa_cl_de_ = this.id_farm + '-' + this.id_client + '-' + this.variety_id + '-' + $('#id_invoiceh').val();
            console.log(fa_cl_de_);

            axios.post(url, {
                id_invoiceh: $('#id_invoiceh').val(),
                id_client: this.id_client,
                id_farm: this.id_farm,
                id_load: $('#id_load').val(),
                variety_id: this.variety_id,
                hawb: this.hawb,
                pieces: this.pieces,
                hb: this.hb,
                qb: this.qb,
                eb: this.eb,
                stems: this.stems, 
                price: parseFloat(this.price),
                bunches: $('#bunches').val(), 
                fulls: parseFloat(this.fulls),  
                total: parseFloat($('#total').val()),
                id_user: $('#id_user').val(),
                update_user: $('#update_user').val(),
                stems_p_bunches: this.stems_p_bunches,
                fa_cl_de: fa_cl_de_,
                client_confim_id: this.client_confim_id
            }).then(response => {
                this.getInvoiceItems();
                this.id_invoiceh = '';
                this.id_client = '';
                this.id_farm = '';
                this.id_load = '';
                this.variety_id = '';
                this.hawb = '';
                this.pieces = '';
                this.hb = '';
                this.qb = '';
                this.eb = '';
                this.stems = '';
                this.price = '';
                this.bunches = '';
                this.fulls = '';
                this.total = '';
                this.id_user = '';
                this.update_user = '';
                this.stems_p_bunches = '';
                this.client_confim_id = '';
                this.errors = [];
                $('#agregarItem').modal('hide');
                $('.client_confirm').hide();
                toastr.success('creado correctamente'); // Mensaje
            }).catch(error => {
                $('.client_confirm').hide();
                toastr.error('Hubo uno o varios errores al guardar '),
                this.errors = error.response.data
            });
        }
    }

    
});
