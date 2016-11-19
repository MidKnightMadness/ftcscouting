<script>
    window.Scouting = {
        csrfToken: '{{csrf_token()}}',

        user: '{{Auth::user()? Auth::id() : 'null'}}'
    }
</script>