<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        if (typeof App !== 'undefined' && typeof App.init === 'function') {
            App.init();
        } else {
            console.error("L'objet 'App' ou la méthode 'init' est introuvable.");
        }
    });
</script>

<script src="{{ asset('assets/js/custom.js') }}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

