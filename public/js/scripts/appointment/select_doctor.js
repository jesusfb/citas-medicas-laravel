let $doctor, $date, $specialty, $hours;
let countRadio;
const noHoursAlert =
    `<div class="alert alert-danger" role="alert">
            <strong>Lo sentimos!</strong> No se encontraron horas disponibles para el médico en el dÍa seleccionado.
    </div>`;
$(function() {
    //console.log("asdasdas");
    $specialty = $('#specialty');
    $date = $('#date');
    $doctor = $('#doctor');
    $hours = $('#hours');
    $specialty.change(() => {
        const specialty_id = $specialty.val();
        const url = `specialties/${specialty_id}/doctors`;
        $.getJSON(url, onDoctorsLoaded); // la funcion se va encargar de manejar el response
    });
    $doctor.change(loadHours);
    $date.change(loadHours);

});

function onDoctorsLoaded(response) {
    let html = '';
    let doctors = response.data;
    doctors.forEach(doctor => {
        html += `<option value="${doctor.id}">${doctor.name}</option>`
    });
    $doctor.html(html);
    loadHours();
}

function loadHours() {
    const doctor_id = $('#doctor').val();
    const date = $('#date').val();
    const url = `/schedule/hours/doctors?date=${date}&doctor_id=${doctor_id}`;
    // SI ESE DOCTOR TRABAJA ESE DIA LES VA MOSTRAR LOS INTERVALOS DE HORAS DISPONIBLES
    // si el doctor no trabaja ese dia se va mostrar un mensaje de "ERROR"
    $.getJSON(url, displayHours);

}

async function displayHours(response) {

    if (!response.morning && !response.afternoon || (response.morning.length == 0 && response.morning.length == 0)) {
        //console.log("EN NO MORNING Y NO AFTERNOON");
        $hours.html(noHoursAlert);
        return;
    }
    let htmlHours = '';
    countRadio = 0;
    if (response.morning) {
        const morning_intervals = response.morning;
        morning_intervals.forEach(interval => {
            //console.log(`EN MORNING ${interval.start} - ${interval.end}`);
            htmlHours += getRadioIntervalHtml(interval);
        });
    }
    if (response.afternoon) {

        const afternoon_intervals = response.afternoon;
        afternoon_intervals.forEach(interval => {
            //   console.log(`EN AFTERNOON ${interval.start} - ${interval.end}`);
            htmlHours += getRadioIntervalHtml(interval);
        });
    }
    $hours.html(htmlHours);
    // FUNCION QUE DEVUELVE EL HTML DE UN RADIO BUTTON A PARTIR DE UN INTERVAL

}

function getRadioIntervalHtml(interval) {
    const text = `${interval.start} - ${interval.end}`;
    return `<div class="custom-control custom-radio mb-3"> 
    <input name="scheduled_time" value="${interval.start}" class="custom-control-input" id="interval${countRadio}" type="radio" value="${text}" required>
    <label class="custom-control-label" for="interval${countRadio++}">${text}</label>
 </div>`;
}

/* USANDO AJAX-JQUERY TRADICIONALMENTE
$(document).ready(() => {
    var specialty_id;
    $('#specialty').change(function() {
        specialty_id = $('#specialty').val();
        $.ajax({
            url: "/specialties/" + specialty_id + "/doctors",
            type: 'GET',
            dataType: "JSON",
            success: function(response) {
                llenarSelectDoctor(response);
            }
        });
    });
});

function llenarSelectDoctor(response) {
    var doctors = response.data;
    var html = "";
    doctors.forEach(doctor => {
        html += `<option value="${doctor.id}">${doctor.name}</option>`;
    });

    $('#doctor').html(html);
}
*/