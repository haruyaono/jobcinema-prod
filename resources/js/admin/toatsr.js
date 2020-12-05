toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "60000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

class Notifier {
    constructor(opt) {
        this.dflt = {
            info: {
                "closeButton": false
            },
            success: {
                "progressBar": true
            },
            warning: {

            },
            error: {

            }
        }
        this.cfg = _.defaults(opt, this.dflt)
        this.status = document.getElementById('SessionStatus') ? document.getElementById('SessionStatus').value : '';
    }

    info(msg, tl, cfgOvr) {
        this.notify('info', msg, tl, cfgOvr);
    }

    success(msg, tl, cfgOvr) {
        this.notify('success', msg, tl, cfgOvr);
    }

    warning(msg, tl, cfgOvr) {
        this.notify('warning', msg, tl, cfgOvr);
    }

    error(msg, tl, cfgOvr) {
        this.notify('error', msg, tl, cfgOvr);
    }

    notify(lvl, msg, tl, cfgOvr) {
        let cfg = this.cfg[lvl];
        if (cfgOvr) {
            cfg = _.defaults(cfgOvr, cfg);
        }
        toastr[lvl](msg, tl, cfg);
    }
}

const notifier = new Notifier();
if (notifier.status) {
    notifier.success(notifier.status);
}
