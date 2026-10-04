(function () {
    function setupLeaveSignaturePads() {
        document.querySelectorAll('[data-leave-signature-canvas]').forEach(function (canvas) {
            if (canvas.dataset.bound === 'true') return;
            canvas.dataset.bound = 'true';

            var context = canvas.getContext('2d');
            var ratio = window.devicePixelRatio || 1;
            var width = canvas.clientWidth;
            var height = canvas.clientHeight;
            canvas.width = width * ratio;
            canvas.height = height * ratio;
            context.scale(ratio, ratio);
            context.strokeStyle = '#172554';
            context.lineWidth = 2.2;
            context.lineCap = 'round';
            context.lineJoin = 'round';
            var drawing = false;

            function point(event) {
                var bounds = canvas.getBoundingClientRect();
                return {
                    x: (event.clientX - bounds.left) * (canvas.clientWidth / bounds.width),
                    y: (event.clientY - bounds.top) * (canvas.clientHeight / bounds.height)
                };
            }

            canvas.addEventListener('pointerdown', function (event) {
                drawing = true;
                canvas.setPointerCapture(event.pointerId);
                var position = point(event);
                context.beginPath();
                context.moveTo(position.x, position.y);
            });

            canvas.addEventListener('pointermove', function (event) {
                if (!drawing) return;
                var position = point(event);
                context.lineTo(position.x, position.y);
                context.stroke();
            });

            function finishDrawing() {
                if (!drawing) return;
                drawing = false;
                var input = document.getElementById(canvas.dataset.inputId);
                if (!input) return;
                input.value = canvas.toDataURL('image/png');
                input.dispatchEvent(new Event('input', { bubbles: true }));
            }

            canvas.addEventListener('pointerup', finishDrawing);
            canvas.addEventListener('pointercancel', finishDrawing);
        });
    }

    function clearSignature(event) {
        var button = event.target.closest('[data-clear-leave-signature]');
        if (!button) return;
        var inputId = button.dataset.clearLeaveSignature;
        var input = document.getElementById(inputId);
        var canvas = document.querySelector('[data-leave-signature-canvas][data-input-id="' + inputId + '"]');
        if (!canvas) return;
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        if (input) {
            input.value = '';
            input.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }

    function attachToLivewire() {
        setupLeaveSignaturePads();
        if (window.Livewire) {
            window.Livewire.hook('message.processed', setupLeaveSignaturePads);
        }
    }

    if (window.Livewire) {
        attachToLivewire();
    } else {
        document.addEventListener('livewire:load', attachToLivewire, { once: true });
    }
    document.addEventListener('click', clearSignature);
})();
