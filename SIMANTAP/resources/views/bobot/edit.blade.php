<div class="modal fade" id="modalEditBobot" tabindex="-1" aria-labelledby="modalEditBobotLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="form-edit-bobot">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditBobotLabel">Edit Bobot Prioritas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="sliders-bobot">
                        @csrf
                        @foreach($bobot as $item)
                        <div class="mb-4 slider-container">
                            <label class="form-label">{{ $item->nama_parameter }}</label>
                            <div class="position-relative">
                                <input 
                                    type="range" 
                                    min="0" 
                                    max="1" 
                                    step="0.01" 
                                    class="form-range bobot-slider" 
                                    name="bobot[{{ $item->bobot_id }}]" 
                                    value="{{ $item->bobot }}">
                                <div class="available-range" style="position: absolute; top: 0; height: 100%; background-color: rgba(0,123,255,0.1); pointer-events: none;"></div>
                            </div>
                            <span class="badge bg-primary ms-2 bobot-value">{{ number_format($item->bobot, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label>Total Bobot: <span id="total-bobot" class="fw-bold text-info"></span></label>
                        <div id="bobot-warning" class="text-danger" style="display:none;">Total bobot harus = 1</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-simpan-bobot" class="btn btn-success" disabled>Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.slider-container {
    position: relative;
}
.available-range {
    position: absolute;
    top: 0;
    height: 100%;
    background-color: rgba(0,123,255,0.1);
    pointer-events: none;
    transition: all 0.2s ease;
}
</style>

<script>
let initialTotal = 0;
let previousValues = {};

// Simpan nilai awal slider
$('.bobot-slider').each(function() {
    previousValues[$(this).attr('name')] = parseFloat($(this).val());
});

function updateTotal() {
    let total = 0;
    $('.bobot-slider').each(function() {
        total += parseFloat($(this).val());
    });
    $('#total-bobot').text(total.toFixed(2));
    
    if (Math.abs(total - 1) < 0.001) {
        $('#btn-simpan-bobot').prop('disabled', false);
        $('#bobot-warning').hide();
    } else {
        $('#btn-simpan-bobot').prop('disabled', true);
        $('#bobot-warning').show();
    }
    
    return total;
}

function updateSliderLimits(changedSlider) {
    let currentTotal = updateTotal();
    let currentSliderName = $(changedSlider).attr('name');
    let currentValue = parseFloat($(changedSlider).val());
    let previousValue = previousValues[currentSliderName];
    let difference = currentValue - previousValue;
    
    // Update nilai previous untuk slider yang berubah
    previousValues[currentSliderName] = currentValue;
    
    // Jika total melebihi 1, kembalikan ke nilai sebelumnya
    if (currentTotal > 1) {
        $(changedSlider).val(previousValue);
        updateTotal();
        return false;
    }
    
    // Update visual range yang tersedia untuk slider lain
    $('.bobot-slider').each(function() {
        if (this !== changedSlider) {
            let container = $(this).closest('.slider-container');
            let availableRange = container.find('.available-range');
            let currentSliderValue = parseFloat($(this).val());
            let maxPossible = 1 - (currentTotal - currentSliderValue);
            
            // Visual indicator untuk range yang tersedia
            if (maxPossible > currentSliderValue) {
                let rangeWidth = $(this).width();
                let currentPos = (currentSliderValue / 1) * rangeWidth;
                let availableWidth = ((maxPossible - currentSliderValue) / 1) * rangeWidth;
                
                availableRange.css({
                    'left': `${currentPos}px`,
                    'width': `${availableWidth}px`,
                    'display': 'block'
                });
            } else {
                availableRange.css('display', 'none');
            }
        }
    });

    // Update nilai yang ditampilkan
    $('.bobot-slider').each(function() {
        $(this).closest('.slider-container').find('.bobot-value')
            .text(parseFloat($(this).val()).toFixed(2));
    });
    
    return true;
}

// Handler untuk perubahan slider
$(document).off('input change', '.bobot-slider').on('input change', '.bobot-slider', function() {
    updateSliderLimits(this);
});

// Inisialisasi
$(document).ready(function() {
    initialTotal = updateTotal();
    updateSliderLimits(null);
});

// Handler submit form
$(document).off('submit', '#form-edit-bobot').on('submit', '#form-edit-bobot', function(e) {
    e.preventDefault();
    
    // Validasi total = 1
    let total = updateTotal();
    if (Math.abs(total - 1) > 0.001) {
        Swal.fire('Gagal', 'Total bobot harus = 1', 'error');
        return;
    }

    let data = $(this).serialize();
    $('#btn-simpan-bobot').prop('disabled', true);

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
                    timer: 1500
                }).then(() => {
                    $('#modalEditBobot').modal('hide');
                    dataBobot.ajax.reload();
                });
            } else {
                Swal.fire('Gagal', res.message, 'error');
            }
        },
        error: function(xhr) {
            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
            console.error(xhr.responseText);
        },
        complete: function() {
            $('#btn-simpan-bobot').prop('disabled', false);
        }
    });
});

</script>