<div class="form-group mb-3">
    <label class="font-weight-bold small d-block">Electronic signature <span class="text-muted font-weight-normal">(optional)</span></label>
    <div wire:ignore>
        <canvas data-leave-signature-canvas data-input-id="{{ $signatureId }}" style="display:block;width:100%;max-width:620px;height:130px;border:1px solid #ced4da;border-radius:4px;background:#fff;touch-action:none;cursor:crosshair;"></canvas>
    </div>
    <input id="{{ $signatureId }}" type="hidden" wire:model.defer="signatureData">
    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" data-clear-leave-signature="{{ $signatureId }}">Clear signature</button>
    <small class="form-text text-muted">Draw your signature above with a mouse, touch screen, or stylus. It will be stored with your decision and timestamp.</small>
</div>
