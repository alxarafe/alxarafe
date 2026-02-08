<script
        src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8="
        crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>

@if ($me->protectChanges ?? false)
<script>
    (function() {
        window.alxarafe_unsaved_changes = false;

        // Warn before leaving
        window.addEventListener('beforeunload', function(e) {
            if (window.alxarafe_unsaved_changes) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Mark as dirty on input/change
        document.addEventListener('input', function(e) {
            if (e.target.closest('form')) {
                window.alxarafe_unsaved_changes = true;
            }
        });
        document.addEventListener('change', function(e) {
            if (e.target.closest('form')) {
                window.alxarafe_unsaved_changes = true;
            }
        });

        // Reset on valid submit
        document.addEventListener('submit', function(e) {
            if (e.target.closest('form')) {
                window.alxarafe_unsaved_changes = false;
            }
        });
    })();
</script>
@endif

{!! $me->getRenderFooter() !!}

@stack('scripts')
