<style>
    .wa-logo {
        position: fixed;
        bottom: 35px;
        right: 35px;
        width: 75px;
        height: 75px;
        z-index: 1000;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }
</style>

{{-- wa logo --}}
<a href="https://wa.me/+6281348669955" target="_blank">
    <img src="{{ asset('img/whatsapp.png') }}" class="wa-logo" alt="WhatsApp">
</a>
{{-- wa logo --}}
