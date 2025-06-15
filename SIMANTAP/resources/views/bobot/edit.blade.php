<div class="modal fade" id="modalEditBobot" tabindex="-1" aria-labelledby="modalEditBobotLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <form id="form-edit-bobot">
                <div class="modal-header text-white bg-light">
                    <div class="d-flex align-items-center w-100">
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0 text-dark">
                                <i class="fas fa-weight-hanging me-2"></i>Edit Bobot Prioritas
                            </h5>
                            <p class="mb-0 small opacity-85 mt-1 text-muted">Penyesuaian bobot parameter</p>
                        </div>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                </div>
                <div class="modal-body p-4">
                    <div id="sliders-bobot">
                        @csrf
                        @foreach($bobot as $item)
                        <div class="mb-3 slider-container">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold" style="font-size: 0.9rem;">{{ $item->nama_parameter }}</label>
                                <span class="badge bg-primary bg-opacity-10 text-primary bobot-value py-1 px-2">{{ number_format($item->bobot, 2) }}</span>
                            </div>
                            <div class="slider-track-wrapper">
                                <!-- Main Slider -->
                                <input
                                    type="range"
                                    min="0"
                                    max="1"
                                    step="0.01"
                                    class="form-range bobot-slider"
                                    name="bobot[{{ $item->bobot_id }}]"
                                    value="{{ $item->bobot }}">
                                <!-- Ghost Slider (on top of everything) -->
                                <div class="ghost-slider" style="width: {{ $item->bobot * 100 }}%"></div>
                            </div>
                            <div class="estimate-info small text-muted mt-1">
                                <span>Maksimum: <span class="estimate-value fw-bold text-primary">{{ number_format(1 - $item->bobot, 2) }}</span></span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="alert alert-info bg-light-info border-0 mt-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                <div>
                                    <span class="fw-semibold small">Total Bobot: </span>
                                    <span id="total-bobot" class="fw-bold">1.00</span>
                                </div>
                                <div id="bobot-warning" class="text-danger mt-1 small" style="display:none;">
                                    <i class="fas fa-exclamation-circle me-1"></i>Total bobot harus tepat 1.00
                                </div>
                                <div class="mt-1">
                                    <span class="text-muted small">Sisa bobot yang dapat dialokasikan:</span>
                                    <span id="remaining-bobot" class="fw-bold text-primary">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" id="btn-simpan-bobot" class="btn btn-primary rounded-pill px-4 shadow-sm btn-sm">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.slider-container {
    position: relative;
    padding: 8px 10px;
    background-color: #f8f9fa;
    border-radius: 6px;
    margin-bottom: 8px;
}

.slider-track-wrapper {
    position: relative;
    height: 24px;
    display: flex;
    align-items: center;
    padding: 0 6px;
}

.bobot-slider {
    position: relative;
    z-index: 2;
    height: 6px;
    -webkit-appearance: none;
    width: 100%;
    background: transparent;
    margin: 0;
}

.bobot-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #0d6efd;
    cursor: pointer;
    margin-top: -5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
    position: relative;
    z-index: 3;
}

.bobot-slider::-webkit-slider-thumb:hover {
    transform: scale(1.1);
    box-shadow: 0 3px 6px rgba(0,0,0,0.2);
}

.bobot-slider::-webkit-slider-runnable-track {
    width: 100%;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
}

.ghost-slider {
    position: absolute;
    left: 6px;
    top: 50%;
    transform: translateY(-50%);
    height: 6px;
    background: rgba(13, 110, 253, 0.3);
    border-radius: 3px;
    z-index: 4;
    pointer-events: none;
    transition: width 0.3s ease;
}

.ghost-slider::after {
    content: '';
    position: absolute;
    right: -3px;
    top: 50%;
    width: 10px;
    height: 10px;
    background: rgba(13, 110, 253, 0.7);
    border-radius: 50%;
    transform: translateY(-50%);
    border: 2px solid white;
    box-shadow: 0 0 0 1px rgba(13, 110, 253, 0.5);
    z-index: 5;
}

.estimate-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.25rem;
    font-size: 0.75rem;
}

.estimate-value {
    margin-left: 0.25rem;
}

.modal-body {
    padding: 1rem;
}

.modal-footer {
    padding: 0.75rem 1rem;
}

.btn-sm {
    font-size: 0.875rem;
    padding: 0.25rem 0.75rem;
}
</style>

<script>
$(document).ready(function() {
    let currentTotal = 1.00;
    let remaining = 0.00;

    function updateVisuals(changedSlider = null) {
        // Calculate current total
        currentTotal = 0;
        $('.bobot-slider').each(function() {
            currentTotal += parseFloat($(this).val());
        });

        remaining = 1 - currentTotal;
        $('#total-bobot').text(currentTotal.toFixed(2));
        $('#remaining-bobot').text(remaining.toFixed(2));

        // Update each slider's ghost indicator and estimate
        $('.slider-container').each(function() {
            const slider = $(this).find('.bobot-slider');
            const currentValue = parseFloat(slider.val());
            const ghostSlider = $(this).find('.ghost-slider');
            const estimateValue = $(this).find('.estimate-value');

            // Calculate max possible value for this slider
            const maxPossible = currentValue + remaining;

            if (slider[0] !== changedSlider && remaining > 0) {
                // Show ghost slider up to max possible position
                ghostSlider.css({
                    'width': `${maxPossible * 100}%`,
                    'opacity': '1'
                });

                estimateValue.text(maxPossible.toFixed(2));
            } else {
                // Hide ghost slider
                ghostSlider.css('opacity', '0');
                estimateValue.text('0.00');
            }

            // Update color based on availability
            if (maxPossible <= 0) {
                estimateValue.removeClass('text-primary').addClass('text-danger');
            } else {
                estimateValue.removeClass('text-danger').addClass('text-primary');
            }
        });

        // Validate total
        if (Math.abs(currentTotal - 1) < 0.001) {
            $('#btn-simpan-bobot').prop('disabled', false);
            $('#bobot-warning').hide();
        } else {
            $('#btn-simpan-bobot').prop('disabled', true);
            $('#bobot-warning').show();
        }
    }

    // Initialize visuals
    updateVisuals();

    // Slider change handler
    $(document).on('input change', '.bobot-slider', function() {
        // Update the displayed value
        const currentValue = parseFloat($(this).val());
        $(this).closest('.slider-container').find('.bobot-value')
            .text(currentValue.toFixed(2));

        // Update all visuals
        updateVisuals(this);

        // If exceeding limits, adjust the value
        if (currentTotal > 1) {
            const excess = currentTotal - 1;
            const newValue = currentValue - excess;
            $(this).val(newValue);
            $(this).closest('.slider-container').find('.bobot-value')
                .text(newValue.toFixed(2));
            updateVisuals(this);
        }
    });

    // Form submission handler
    $(document).on('submit', '#form-edit-bobot', function(e) {
        e.preventDefault();

        if (Math.abs(currentTotal - 1) > 0.001) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Total bobot harus tepat 1.00',
                confirmButtonColor: '#dc3545',
                backdrop: 'rgba(0,0,0,0.4)'
            });
            return;
        }

        let data = $(this).serialize();
        $('#btn-simpan-bobot').prop('disabled', true);
        $('#btn-simpan-bobot').html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

        $.ajax({
            url: "{{ route('bobot.updateAll') }}",
            type: "POST",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if(res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500,
                        backdrop: 'rgba(0,0,0,0.4)'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message,
                        confirmButtonColor: '#dc3545',
                        backdrop: 'rgba(0,0,0,0.4)'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan server',
                    confirmButtonColor: '#dc3545',
                    backdrop: 'rgba(0,0,0,0.4)'
                });
                console.error(xhr.responseText);
            },
            complete: function() {
                $('#btn-simpan-bobot').prop('disabled', false);
                $('#btn-simpan-bobot').html('<i class="fas fa-save me-1"></i>Simpan');
            }
        });
    });
});
</script>
