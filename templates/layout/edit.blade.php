<div class="alxarafe-resource-edit animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 fw-bold text-dark">
            <i class="fas fa-edit text-primary me-2"></i>[trans:edit_record]
        </h3>
        <div class="actions">
            <button class="btn btn-outline-secondary me-2" onclick="history.back()">
                <i class="fas fa-arrow-left me-1"></i> [trans:back]
            </button>
            <button class="btn btn-success shadow-sm" id="btn-save">
                <i class="fas fa-save me-1"></i> [trans:save]
            </button>
        </div>
    </div>

    <div id="edit-form-container">
        <div class="text-center p-5">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2 text-muted">[trans:loading_data]</p>
        </div>
    </div>
</div>
